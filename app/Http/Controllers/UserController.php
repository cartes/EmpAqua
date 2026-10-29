<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use App\Http\Requests\PersonalDataRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\Message;
use App\Models\Offers;
use App\Models\Search;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Validator;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(Request $request)
    {
        $usr = $request->email;
        $user = User::where('email', $usr)
            ->with(['messages'])
            ->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->regenerate();
                $array = [
                    'id' => $user->id,
                    'role' => 'user',
                    'name' => $user->name . ' ' . $user->surname,
                ];
                session($array);
                return back();
            } else {
                return redirect(route('home'))->with('message', ['danger', 'Combinación email y clave no corresponden']);
            }
        } else {
            return back()->with('message', ['danger', 'Usuario no existe']);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }






    /**
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRegisterRequest $request)
    {
        $pass = Hash::make($request->passwordUser);

        $request->merge(['password' => $pass]);
        $request->merge(['rut_user' => $request->rut_candidate]);
        $validator = Validator::make($request->all(), $request->rules());
        $user = User::create($request->input());

        session([
            'id' => $user->id,
            'role' => 'user',
            'name' => $user->name . ' ' . $user->surname
        ]);

        return redirect()->route('profile')->with('message', ['success', 'Registro exitoso']);
    }
    
    
    
    
    
    

    public function alerts()
    {
        $id = session()->get("id");

        $searches = Search::whereUserId($id)->select('search_term')->get();

        if ($searches->count() > 0) {
            $alerts = Offers::where(function ($q) use ($searches) {
                foreach ($searches as $search) {
                    $q->orWhere('title', 'like', '%' . $search->search_term . '%');
                }
            })
                ->with(['business', 'businessMeta'])
                ->whereDate('expirated_at', '>=', Carbon::now())
                ->get();
        } else {
            $alerts = Offers::where('title', 'LIKE', '%trabajo%')
                ->whereDate('expirated_at', '>=', Carbon::now())->get();
        }

        $postulated = Candidates::whereIdUser($id)
            ->select([
                'aquabe_offers_candidates.id',
                'aquabe_offers_candidates.status',
                'aquabe_offers.title',
                'aquabe_offers.slug as slug',
                'aquabe_business_meta.fantasy_name as fantasy_name',
                'aquabe_business_meta.comune as comune',
                'aquabe_offers.created_at',
                'aquabe_offers_candidates.status'])
            ->leftJoin('aquabe_offers', 'aquabe_offers_candidates.id_offer', '=', 'aquabe_offers.id')
            ->leftJoin('aquabe_business_meta', 'aquabe_offers.id_business', '=', 'aquabe_business_meta.id_business')
            ->whereDate('aquabe_offers.expirated_at', '>=', Carbon::now())
            ->get();

        $user = User::whereId($id)
            ->with(['userMeta', 'userExperience', 'userSkills', 'userEducation', 'userReferences'])
            ->first();

        return view("user.alerts")->with([
            'alerts' => $alerts,
            'user' => $user,
            'postulated' => $postulated
        ]);
    }

    public function showoffers()
    {
        $id = session()->get('id');
        $user = User::where('id', $id)->first();

        $candidates = User::where('id', $id)
            ->first()
            ->offers
            ->where('pivot.status', '!=', '4')
            ->where('expirated_at', '>=', Carbon::now());

        $messages = Message::whereUserId($id)->get();

        return view('user.offers')->with([
            'user' => $user,
            'candidates' => $candidates,
            'messages' => $messages
        ]);
    }

    public function favorites()
    {
        $id = session()->get('id');
        $user = User::where('id', $id)->first();

        $candidates = User::where('id', $id)
            ->first()
            ->offers
            ->where('pivot.status', '=', '4')
            ->where('expirated_at', '>=', Carbon::now());

        $messages = Message::whereUserId($id)->get();

        return view('user.favorites')->with([
            'user' => $user,
            'candidates' => $candidates,
            'messages' => $messages
        ]);
    }


    public function file(User $id, $offer = null)
    {
        if (!is_null($offer)) {
            Candidates::where('id_user', '=', $id->id)
                ->where('id_offer', '=', $offer)
                ->update(['status' => Candidates::REVIEWED]);
        }
        $user = User::whereId($id->id)->with('userMeta', 'userExperience', 'userLanguage', 'userSkills', 'userEducation')->first();

        return view('user.file')->with(['user' => $user]);
    }
}
