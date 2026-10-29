<?php
namespace App\Http\Controllers;

use App\Benefit;
use App\Business;
use App\Candidates;
use App\Category;
use App\Role;
use App\Http\Requests\CreateOfferRequest;
use App\Http\Requests\OfferEditRequest;
use App\Offers;
use App\CandidateStatus;
use App\User;
use App\UserMeta;
use App\UserEducation;
use App\UserExperience;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator as Validator;
use DataTables;

// Comporbacion de palabras en lista negra
use App\Rules\BlacklistWords;


class OfferController extends Controller
{
    public function index()
    {
        $id = session()->get('id');
        $role = session()->get('role');

        $count = $this->getCountFeatured($id);
        $ads = $this->ads(session()->get('role_id'));

        session()->put('ads', $ads - $count);


        $role_id = session()->get('role_id');

        $role_name = '';

        switch ($role_id) {
            case 10 :
                $role_name = 'Básico';
                break;
            case 11 :
                $role_name = 'Premium';
                break;
            case 16 :
                $role_name = 'Gold';
                break;
            case 12 :
                $role_name = 'Corporativo A1';
                break;
            case 13 :
                $role_name = 'Corporativo A2';
                break;
            case 14 :
                $role_name = 'Corporativo A3';
                break;
            case 15 :
                $role_name = 'Corporativo A4';
                break;
            case 16 :
                $role_name = 'Corporativo A5';
                break;
            case 16 :
                $role_name = 'Corporativo Plus';
                break;
            case 90:
                $role_name = 'Gratis';
                break;
        }

        if (!$id) {
            return redirect()->route('home');
        }
        $offers = Offers::where('id_business', $id)
            ->select(['id', 'id_business', 'title', 'visit', 'featured', 'published', 'slug', 'created_at', 'expirated_at'])
            ->withCount('Candidates')
            ->whereDate('expirated_at', '>=', Carbon::now())
            ->with(['businessMeta', 'Benefits', 'candidates', 'User'])
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        $expired = Offers::where('id_business', $id)
            ->whereDate('expirated_at', '<', Carbon::now())
            ->orderBy('created_at')
            ->paginate(25);

        $business = Business::where('id', '=', $id)
            ->with('business_meta')
            ->withcount('offers')
            ->first();

        $candidates = [];
        
        foreach ($offers->all() as $candidate) {
            $item = $candidate->User->all();
            if (count($item) > 0) {
                foreach ($item as $i) {
                    $candidates[] = $i;
                }
            }
        }
        $collection = Collection::make($candidates);

        $featured = $this->ads(session()->get('role_id'));

        return view('offers.index')
            ->with([
                'expired' => $expired,
                'business' => $business,
                'offers' => $offers,
                'candidates' => $collection->groupBy('id'),
                'role' => $role_name,
                'featured' => $featured,
            ]);
    }
    
    /**
     * Aborta con 403 si la oferta no pertenece a la empresa en sesión
     * (el administrador puede operar sobre cualquier oferta).
     */
    protected function authorizeOwner(Offers $offer)
    {
        if (session()->get('role') === 'administrador') {
            return;
        }
        abort_unless($offer->id_business == session()->get('id'), 403, 'No autorizado');
    }

    public function unpublish(Offers $offer)
    {
        $this->authorizeOwner($offer);
        $offerState = $offer->update([
            'published' => 0
        ]);
        
        return back()->with('message', ['success', 'La oferta se ocultó correctamente']);
    }

    public function republishState(Offers $offer)
    {
        $this->authorizeOwner($offer);
        $offerState = $offer->update([
            'published' => 1
        ]);
        
        return back()->with('message', ['success', 'La oferta se republicó correctamente']);
    }

    public function detail(Offers $offer)
    {
        $id = session()->get('id');

        if ($offer->id_business == $id) {
            $business = Business::whereId($id)->with('business_meta')->first();
            $benefits = Benefit::whereOfferId($offer->id)->get();
            $categories = Category::all();

            return view('offers.detail')
                ->with([
                    'offer' => $offer,
                    'business' => $business,
                    'benefits' => $benefits,
                    'categories' => $categories,
                ]);
        } else {
            $offers = Offers::where('id_business', $id)->paginate(25);

            return redirect()->route('offer.admin', compact('offers'))->with('message', ['danger', 'No estas autorizado para administrar esta oferta']);
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => ['required', new BlacklistWords()],
            'category_id' => 'required',
            'position' => 'required',
            'salary_opt' => 'required',
            'comune' => 'required',
            'handicapped' => 'required',
            'description' => ['required', new BlacklistWords()],
            'area' => 'required',
            'experience' => 'required',
            'requirements' => ['required', new BlacklistWords()],
            'vacancy' => 'required',
        ], [
            'salary_opt.required' => 'Debe ingresar una opcion de renta',
            'salary.integer' => "Renta ofrecida no puede contener puntos ni comas",
            'salary.numeric' => 'Renta ofrecida debe ser un valor numérico',
            'salary.min' => 'Renta ofrecida debe tener un valor de al menos 1',
            'comune.required' => 'La comuna es obligatoria',
            'category_id.required' => 'Debe seleccionar una categoría',
            'handicapped.required' => 'Campo obligatorio',
            'position.required' => 'La Jornada es un campo obligatorio',
            'description.required' => 'La descripción es un campo obligatorio',
            'requirements.required' => 'Los requisitos son obligatorios',
            'vacancy.required' => 'Las vacantes son un campo obligatorio'
        ]);
        

        $opt = $request->input('salary_opt');

        if ($opt == '0') {
            $salary = 0;
        } else if ($opt == '1') {
            $salary = $request->input('salary');
        } else {
            $salary = $request->input('salaryMin') . ' - ' . $request->input('salaryMax');
        };
        
        if ($request->get('status') == 'on') {
            $request->merge(['status' => true]);
        } else {
            $request->merge(['status' => false]);
        }

        $request->merge(['salary_array' => $opt]);
        $request->request->remove('salary');
        $request->merge(['salary' => $salary]);
        $last_id = \DB::table('aquabe_offers')->latest()->first();
        $business_id = session()->get('id');
        $slug = Str::slug($request->get('title') . '-' . $last_id->id);

        // El slug debe ser único: si ya existe, se agrega un sufijo incremental.
        $base_slug = $slug;
        $n = 2;
        while (Offers::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $base_slug . '-' . $n++;
        }

        $expiration = Carbon::now()->addDays(30);

        $request->merge(['id_business' => $business_id]);
        $request->merge(["sub_area" => "NULL"]);
        $request->merge(['slug' => $slug]);
        $request->merge(['expirated_at' => $expiration]);

        $benefits = null;
        if (is_array($request->benefits)) {
            $benefits = $request->benefits;
            $request->request->remove('benefits');
        }
        $offer = Offers::create($request->input());
        $offer_id = $offer->id;

        if (!is_null($benefits)) {
            foreach ($benefits as $benefit) {
                Benefit::create([
                    'offer_id' => $offer_id,
                    'benefit' => $benefit
                ]);
            }
        }

        return redirect()->route('offer.show', $offer->slug)->with('message', ['success', 'Publicación de nueva oferta exitosa']);
    }

    public function store(Request $request, Offers $offer)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'position' => 'required',
            'salary_opt' => 'required|numeric',
            'handicapped' => 'required|in:0,1',
            'description' => 'required|min:10|max:3500',
            'area' => 'required',
            'experience' => 'required|integer',
            'requirements' => 'required',
            'vacancy' => 'required|integer',
        ], [
            // Mensajes de error personalizados si es necesario
        ]);
        
        $money = str_replace('.', '', $request->salary);
        $salary = intval($money);

        $request->merge(['salary' => $salary]);
        $id = session()->get('id');

        if ($id == $offer->id_business) {
            $offer_id = $offer->id;


            if (is_array($request->benefits)) {
                $benefits = $request->benefits;
                $request->request->remove('benefits');
                Benefit::where('offer_id', $offer_id)->delete();

                foreach ($benefits as $benefit) {
                    Benefit::create([
                        'offer_id' => $offer_id,
                        'benefit' => $benefit
                    ]);
                }

            }
            
            if ($request->get('status') == 'on') {
                $request->merge(['status' => true]);
            } else {
                $request->merge(['status' => false]);
            }

            //dd($request->input());
            $offer->fill($request->input())->save();

            if (!is_null($request->benefit)) {
                Benefit::create([
                    'offer_id' => $offer_id,
                    'benefit' => $request->benefit
                ]);
            }

            return back()->with('message', ['success', 'Datos actualizados']);
        } else {
            return redirect()->route('offer.admin')->with('message', ['danger', 'No estás autorizado para corregir estos datos']);
        }

    }

    public function show(Request $request)
    {
        $slug = $request->route('slug');
        $search = $request->route('search');
        $featured = request()->featured;

        $id = session()->get('id');

        $academics = UserEducation::whereIdUser($id)->count();
        $meta = UserMeta::where('id_user', $id)->first();
        
        $filename = false;
        
        if ($meta && $meta->filename != '') {
            $filename = true;
        }

        if (is_null($search)) {
            if ($featured) {
                $query = Offers::whereDate('expirated_at', '>=', Carbon::now())
                    ->where('featured', '=', '1')
                    ->where('published', '=', '1')
                    ->with(['businessMeta', 'business', 'Benefits', 'candidates', 'category'])
                    ->latest()->paginate(15);
            } else {
                $query = Offers::whereDate('expirated_at', '>=', Carbon::now())
                    ->with(['businessMeta', 'business', 'Benefits', 'candidates', 'category'])
                    ->where('published', '=', '1')
                    ->latest()->paginate(15);
            }
        } else {
            if ($featured) {
                $query = Offers::where('title', 'LIKE', "%{$search}%")
                    ->where('featured', '=', '1')
                    ->whereDate('expirated_at', '>=', Carbon::now())
                    ->with(['businessMeta', 'business', 'Benefits', 'candidates', 'category'])
                    ->latest()
                    ->paginate(15);

            } else {
                $query = Offers::where('title', 'LIKE', "%{$search}%")
                    ->whereDate('expirated_at', '>=', Carbon::now())
                    ->with(['businessMeta', 'business', 'Benefits', 'candidates', 'category'])
                    ->latest()
                    ->paginate(15);
            }
        }
        

        $offer = Offers::whereSlug($slug)->with('candidates')->first();

        if(is_object($offer)) {
            if ( $offer->id_business != $id ) {
                Offers::whereSlug($slug)->update([
                    'visit' => $offer->visit + 1
                ]);
            }
            $offer_id = $offer->id;
        } else {
            $offer_id = null;
        }
        
        if (isset($offer->status)) {
            if (is_null($offer->status) || $offer->status == '1') {
                $offer->businessMeta->business_name = 'Prestigiosa Empresa';
            }
        }


        $favorite = Candidates::whereIdUser($id)
            ->where('id_offer', '=', $offer_id)
            ->where('status', '=', '4')
            ->first();

        $candidate = Candidates::where('id_user', '=', $id)->where('id_offer', '=', $offer_id)->first();

        $postuled = is_null($candidate) ? false : true;
        $favorite = is_null($favorite) ? false : true;

        if(!is_null($candidate)) {
            if ($candidate->status['text'] == 'favorite')  {
                $favorite = true;
            }
        }
        
        return view('offers.postulate')
            ->with([
                'search' => $search,
                'hasCV' => $filename,
                'academics' => $academics,
                'offer' => $offer,
                'slug' => $slug,
                'offers' => $query,
                'postuled' => $postuled,
                'featured' => $featured,
                'favorite' => $favorite
            ]);
    }

    public function postulate(Offers $offer)
    {
        $id = session()->get('id');
        
        if (!$id) {
            return back()->with('message', ['danger', 'Debes iniciar sesión para postular']);
        }
    
        // Usamos updateOrCreate para que si ya existe, solo actualice (o no haga nada)
        // en lugar de crear un registro nuevo cada vez.
        Candidates::updateOrCreate(
            [
                'id_user'  => $id,
                'id_offer' => $offer->id
            ],
            [
                'status' => 0 // O el estado inicial que desees
            ]
        );
    
        return back()->with('message', ['success', 'Has postulado a esta oferta de trabajo']);

//        if (!is_null($id)) {
//
//            $candidate = new Candidates;
//
//            $candidate->id_user = $id;
//            $candidate->id_offer = $offer->id;
//            $candidate->status = 0; // 0 = no Favorito, postulado
//
//            $candidate->save();
//        }
//        return back()->with('message', ['success', 'Has postulado a esta oferta de trabajo']);
    }

    public function favorite(Request $request) {
        $id = session()->get('id');
        if (is_null($id)) {
            return response()->json(['error' => 'No estás autorizado para realizar esta acción']);
        }

        if ($request->ajax()) {
            $offer = Offers::whereSlug($request->id_offer)->first();

            $fav = Candidates::whereIdUser($id)
                ->where('id_offer', '=', $offer->id)
                ->where('status', '=', '4')
                ->first();

            if (is_null($fav)) {
                Candidates::whereIdUser($id)->where('id_offer', '=', $offer->id)->firstOrCreate([
                    'id_offer' => $offer->id,
                    'id_user' => $id,
                    'status' => 4, // 4 = Favorito
                ]);
                $isFavorite = 4;
            } else {
                Candidates::whereIdUser($id)->where('id_offer', '=', $offer->id)->delete();
                $isFavorite = 0;
            }

            return response()->json([
                'code' => 200,
                'message' => 'OK - ' . $offer->id . ' - ' . $id . ' - ',
                'isFavorite' => $isFavorite
            ], 200);
        } else {
            return response()->json([
                'code' => 400,
                'message' => 'Bad Request',
            ], 400);
        }
    }

    public function destroy(Offers $offer)
    {
        $this->authorizeOwner($offer);
        try {
            $offer->delete();

            return back()->with('message', ['success', 'Oferta eliminada correctamente']);
        } catch (\Exception $exc) {
            return back()->with('message', ['danger', 'Error: $exc->getmessage()']);
        }
    }

    public function republish($slug)
    {
        $id = session()->get('id');

        if ($id) {
            $offer = Offers::whereSlug($slug)->first();
            
            if ($offer) {
                $this->authorizeOwner($offer);
                $offer->candidates()->delete();  // Elimina todas las relaciones de candidatos
                $new_exp = Carbon::now()->addDays(30);
                $new_creation = Carbon::now();
                $offer->update([
                    'expirated_at' => $new_exp,
                    'created_at' => $new_creation
                ]);
            }
        }

        return redirect()->route('offer.admin');
    }

    public function ajax($slug)
    {
        $offer = Offers::whereSlug($slug)
            ->with(['businessMeta', 'Benefits'])
            ->first();

        return response()->json($offer);
    }

    private function getCountFeatured($id)
    {
        $featured = Offers::whereDate('expirated_at', '>', Carbon::now())
            ->where('featured', '=', '1')
            ->where('published', '=', '1')
            ->where('id_business', '=', $id)
            ->get();

        return count($featured);
    }

    public function featured(Request $request)
    {
        $id = session()->get('id');
        $action = filter_var($request->get('feature'), FILTER_VALIDATE_BOOLEAN);
        $adId = $request->get('id');

        $ads = $this->ads(session()->get('role_id'));
        $count = $this->getCountFeatured($id);

        if (!$action) {
            $count--;
        }

        $offer = Offers::select('created_at')->where('id', '=', $adId)->where('id_business', '=', $id)->firstOrFail();

        $expiration = Carbon::parse($offer->created_at)->addDays(45);


        if (intval($ads) == 0 || $count >= intval($ads)) {
            Offers::where('id_business', '=', $id)
                ->where('featured', '=', true)
                ->update(['featured' => false]);

            $message = 'Excedió o no tiene acceso a avisos destacados';

            session()->put('ads', $ads);
            session()->put('message', ['danger', $message]);

            return \Response::json([
                'code' => 401,
                'message' => $message,
            ], 400);
        } else {
            Offers::where('id_business', '=', $id)
                ->where('id', '=', $adId)
                ->update([
                    'featured' => $action,
                    'expirated_at' => $expiration,
                ]);
            $message = ($action) ? "La oferta de trabajo $adId se ha destacado" : "La oferta de trabajo $adId se ha dejado normal";

            $count = $this->getCountFeatured($id);

            session()->put('ads', $ads - $count);
            session()->put('message', ['success', $message]);

            return \Response::json([
                'code' => 200,
                'message' => $message,
            ], 200);
        }
    }

    public function list()
    {
        $id = session()->get('id');

        $allFeatured = Offers::whereDate('expirated_at', '>', Carbon::now())
            ->where('featured', '=', '1')
            ->where('published', '=', '1')
            ->with(['business', 'businessMeta', 'candidates', 'category'])
            ->orderBy('created_at', 'DESC')
            ->get();

        $featured = $allFeatured->filter(function ($model) {
            return $model->featured_end_date >= Carbon::now();
        });


        $offers = Offers::whereDate('expirated_at', '>', Carbon::now())
            ->orderBy('created_at', 'desc')
            ->where('published', '=', '1')
            ->with(['business', 'businessMeta', 'candidates', 'category'])
            ->paginate(15);

        $favorite = Candidates::whereIdUser($id)
            ->where('id_offer', '=', $offers[0]->id)
            ->where('status', '=', '4')
            ->first();

        if (count($featured) > 0) {
            $offer_id = $featured->first()->id;

            $merged = $featured->merge($offers)->sortBy('created_at');

            $candidate = Candidates::whereIdUser($id)->where('id_offer', '=', $offer_id)->first();
        } else {
            $candidate = null;
        }
        $postuled = is_null($candidate) ? false : true;

        $favorite = is_null($favorite) ? false : true;

        if(!is_null($candidate)) {
            if ($candidate->status['text'] == 'favorite')  {
                $favorite = true;
            }
        }
         
        if ($offers[0]->confidential && !is_null($offers[0]->businessMeta)) {
            $offers[0]->businessMeta->business_name = 'Prestigiosa Empresa';
        }

        return view('offers.list')
            ->with([
                'offers' => $offers,
                'featured' => null,
                'favorite' => $favorite,
                'postuled' => $postuled
            ]);
    }

    public function list_featured() {
        $id = session()->get('id');

        $offers = Offers::whereDate('expirated_at', '>', Carbon::now())
            ->where('featured', '=', '1')
            ->where('published', '=', '1')
            ->with(['business', 'businessMeta', 'candidates'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        $favorite = null; // valor por defecto

        if ($offers->isNotEmpty()) {
            $favorite = Candidates::whereIdUser($id)
                ->where('id_offer', '=', $offers[0]->id)
                ->where('status', '=', '4')
                ->first();
        }

        $favorite = is_null($favorite) ? false : true;
        

        return view('offers.list')
            ->with([
                'offers' => $offers,
                'featured' => true,
                'favorite' => $favorite,
                'postuled' => false
            ]);
    }

    public function candidates($slug)
    {
        $offer = Offers::whereSlug($slug)
            ->first();

        $take = $this->records(session()->get('role_id'));

        $candidates = Candidates::where("id_offer", "=", $offer->id)
            ->take($take)
            ->orderBy('favorite', 'DESC')
            ->with(['user', 'user.userMeta', 'user.userEducation', 'candidateStatus' => function($query) use ($offer) {
                $query->where('offer_id', '=', $offer->id);
            }])
            ->get();
            
        return view('business.candidates')->with([
            'offer' => $offer,
            'candidates' => $candidates
        ]);
    }
    
    public function updateCandidateStatus(Request $request) 
    {
        $request->validate([
            'candidate_id' => 'required|exists:aquabe_users,id',
            'offer_id' => 'required|exists:aquabe_offers,id',
            'status' => 'required|string'
        ]);
    
        $this->authorizeOwner(Offers::findOrFail($request->offer_id));

        // Buscar o crear un nuevo registro de estado del candidato
        $status = CandidateStatus::updateOrCreate(
            ['candidate_id' => $request->candidate_id, 'offer_id' => $request->offer_id],
            ['status' => $request->status]
        );
    
        return response()->json(['success' => true, 'status' => $status]);
    }
    
    public function addFavoriteCandidate(Request $request)
    {
        $offer = $request->offer;
        $user = $request->user;

        if (!$request->ajax()) {
            abort(400);
        }

        $this->authorizeOwner(Offers::findOrFail($offer));

        $candidate = Candidates::where("id_offer", "=", $offer)
            ->where("id_user", "=", $user)
            ->first();
            
        if($candidate->favorite != 0) {
            $bool = false;
        } else {
            $bool = true;
        };
        
        Candidates::where("id_offer", "=", $offer)
        ->where("id_user", "=", $user)
        ->update([
            'favorite' => $bool        
        ]);
    }

    public function getRelatedSlugs($slug, $id = 0)
    {
        return Offers::where('slug', 'LIKE', "%{$slug}%")
            ->select('slug')
            ->get();
    }

    public function all_candidates($slug) {
        $offer = Offers::whereSlug($slug)
            ->first();

        $id = session()->get('id');
        $role_id = Role::where("id_business", "=", $id)->first();

        $candidates = User::with('userMeta', 'userEducation')->get();
        
        return view("business.allcandidates")->with([            
            'offer' => $offer,
            'candidates' => $candidates
        ]);
    }
    
    public function apiOfertasDestacadas()
    {
        $ofertas = Offers::query()
            ->where('published', 1)
            ->where('expirated_at', '>', now())
            ->with(['business', 'businessMeta'])
            ->orderByDesc('created_at')
            ->limit(8)
            ->get()
            ->map(function ($offer) {
                $empresa = 'Confidencial';
                $logo = null;
    
                if (!$offer->confidential && $offer->businessMeta) {
                    $empresa = $offer->businessMeta->business_name
                        ?? 'Confidencial';
    
                    $logo = $offer->businessMeta->logo ?? null;
                }
    
                return [
                    'id'           => $offer->id,
                    'title'        => $offer->title,
                    'slug'         => $offer->slug,
                    'empresa'      => $empresa,
                    'logo'         => $logo,
                    'description'  => $offer->description,
                    'area'         => $offer->area,
                    'city'         => $offer->city,
                    'comune'       => $offer->comune,
                    'salary'       => $offer->salary,
                    'position'     => $offer->position,
                    'experience'   => $offer->experience,
                    'vacancy'      => $offer->vacancy,
                    'featured'     => (bool) $offer->featured,
                    'created_at'   => $offer->created_at,
                    'updated_at'   => $offer->updated_at,
                    'expirated_at' => $offer->expirated_at,
                    'url'          => url('/offer/show/' . $offer->slug),
                ];
            });
    
        return response()->json([
            'success' => true,
            'total'   => $ofertas->count(),
            'data'    => $ofertas,
        ]);
    }
        

    public function all_candidates_data(Request $request) {
        $userQuery = User::orderBy('created_at', 'desc')
            ->whereNotNull('nacionality')
            ->whereNotNull('marital_status')
            ->whereDoesntHave('offers') // Asume que tienes una relación 'offers' en tu modelo User
            ->with(['userMeta', 'userEducation' => function ($query) {
              $query->whereNotNull('studies');
            }]);
        
        // Deja al postulante en la oferta
        if ($request->has('idCandidate') && $request->has('offerId')) {
            $offerId = $request->offerId;
            $candidateId = $request->idCandidate;
    
            $offer = Offers::find($offerId);
            $candidate = User::find($candidateId);
            
            if ($offer && $candidate) {
                $newCandidate = new Candidates([
                    'id_offer' => $offerId, // Asegúrate de que 'offer_id' es el nombre correcto de la columna.
                    'id_user' => $candidateId,
                    'status' => 0,  // 0 = no Favorito, postulado
                ]);
                $newCandidate->save(); // Crea un nuevo candidato y lo vincula automáticamente a la oferta.
            }
        }
        
        // Filtro de estudios
        if ($request->has('studies') && count($request->studies) > 0) {
            $userQuery->whereHas('userEducation', function ($query) use ($request) {
                $query->whereIn('studies', $request->studies);
            });
        }
    
        // Filtro de región
        if ($request->has('region') && count($request->region) > 0) {
            $userQuery->whereHas('userMeta', function ($query) use ($request) {
                $query->whereIn('state', $request->region);
            });
        }
    
        // Filtro de rango de edad personalizado usando la columna 'birthday'
        if ($request->has('ageRange') && count($request->ageRange) > 0) {

            $userQuery->where(function ($query) use ($request) {
                foreach ($request->ageRange as $range) {
                    $values = explode("-", $range);

                    $minAge = Carbon::now()->subYears($values[1])->format('d-m-Y');
                    $maxAge = Carbon::now()->subYears($values[0])->format('d-m-Y');
                    
                    $query->orWhereRaw("STR_TO_DATE(birthday, '%d-%m-%Y') BETWEEN STR_TO_DATE(?, '%d-%m-%Y') AND STR_TO_DATE(?, '%d-%m-%Y')", [$minAge, $maxAge]);
                }
            });
        }
        
        // Custom Age
        if ($request->has('customAgeMin') && $request->has('customAgeMax')) {
            $minAge = $request->customAgeMin ?: 0; // Edad mínima por defecto si no se proporciona
            $maxAge = $request->customAgeMax ?: 100; // Edad máxima por defecto si no se proporciona        
            // Asegurarse de que los valores mínimos y máximos son lógicos
            if ($minAge > $maxAge) {
                list($minAge, $maxAge) = [$maxAge, $minAge];
            }
        
            $minDate = Carbon::now()->subYears($maxAge)->format('d-m-Y');
            $maxDate = Carbon::now()->subYears($minAge)->format('d-m-Y');
        
            $userQuery->where(function ($query) use ($minDate, $maxDate) {
                $query->orWhereRaw("STR_TO_DATE(birthday, '%d-%m-%Y') BETWEEN STR_TO_DATE(?, '%d-%m-%Y') AND STR_TO_DATE(?, '%d-%m-%Y')", [$minDate, $maxDate]);
            });
        }
        
        // Filtro de género
        if ($request->has('gender') && count($request->gender) > 0) {
            $userQuery->whereIn('gender', $request->gender);
        }
        
        // Custom Gender
        if ($request->has('customGender') &&  $request->customGender != '') {
            $gender = $request->customGender;
        
            // Asegúrate de que el valor de género es un valor esperado o válido
            $userQuery->where(function ($query) use ($gender) {
                $query->orWhereRaw("LOWER(gender) = LOWER(?)", [$gender]);
            });
            
        }
    
        // Filtro de género personalizado
        if (!empty($request->customGender)) {
            $userQuery->orWhere('gender', $request->customGender);
        }
        
        //Filtro curriculum fecha
        if (!empty($request->cvMin)) {
            $userQuery->whereHas('userMeta', function ($query) use ($request) {
                $query->where('updated_at', '>', $request->cvMin);
            });
            
        }
        if (!empty($request->cvMax)) {
            $userQuery->whereHas('userMeta', function ($query) use ($request) {
                $query->where('updated_at', '<', $request->cvMax);
            });
            
        }

        
        $candidates = $userQuery->get();
    
        return DataTables::of($candidates)
            ->addColumn("id", function($user) {
                return '<input type="checkbox" class="id-candidate" name="id-'. $user->id .'" value="' . $user->id . '">';
            })
            ->addColumn("name", function ($user) {
                $name = $user->name . ' ' . $user->surname;
                return '<a href="' . route('user.file', $user->id) .'" target="_blank">' . $name . "</a>";
            })
            ->addColumn("age", function ($user) {
                return Carbon::parse($user->birthday)->age;
            })
            ->addColumn('education_level', function ($user) {
                // Asume que cada usuario tiene al menos una entrada de educación y devuelve el nivel más alto
                $output = '';
                foreach($user->userEducation as $education ) {
                    $output .= '<p style="disply: block; width: 100%; padding: 0; margin: 0">' . $education->studies_level .'</p>' ;
                } 
                return $output != ''? $output : 'N/A';
            })
            ->addColumn("nationality", function ($user) {
                return $user->nacionality ?? 'N/A';
            })
            ->addColumn("region", function($user) {
                return $user->UserMeta->state ?? 'N/A';
            })
            ->addColumn("phone", function ($user) {
                return $user->UserMeta->phone ?? 'N/A';
            })
            ->addColumn("CV", function($user) {
                if ($user->userMeta) {
                    if (!is_null($user->userMeta->path)) {
                        $output = '<a target="_blank" href="'. asset( 'storage/resume/' . $user->userMeta->path ) .'"><i style="font-size: 20px;" class="far fa-file-alt"></i></a>';
                        
                    } else {
                        $output = "<p>Sin CV</p>";
                    }
                } else {
                    $output = "<p>Sin Meta</p>";
                }
                return $output;
            })
            ->rawColumns(['id', 'name', 'CV', 'education_level'])
            ->make(true);
    }

    private function ads($role)
    {
        switch ($role) {
            case '90':
                $take = 0;
                break;
            case '10':
                $take = 3;
                break;
            case '11':
                $take = 6;
                break;
            case '16':
                $take = 9;
                break;
            case '12':
                $take = 10;
                break;
            case '13':
                $take = 12;
                break;
            case '14':
                $take = 15;
                break;
            case '15':
                $take = 30;
                break;
            case '16':
                $take = 45;
                break;
            case '17':
                $take = 45;
                break;
            default:
                $take = 0;
                break;
        }

        return $take;

    }

    private function records($role)
    {
        switch ($role) {
            case '90':
                $take = 1;
                break;
            case '10':
                $take = 20;
                break;
            case '11':
                $take = 35;
                break;
            case '16':
                $take = 50;
                break;
            case '12':
                $take = -1;
                break;
            case '13':
                $take = -1;
                break;
            case '14':
                $take = -1;
                break;
            case '15':
                $take = -1;
                break;
            case '16':
                $take = -1;
                break;
            case '17':
                $take = -1;
                break;
            default:
                $take = 3;
                break;
        }

        return $take;
    }
}
