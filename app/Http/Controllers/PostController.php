<?php

namespace App\Http\Controllers;

use App\Business;
use App\BusinessMeta;
use App\Category;
use App\Http\Requests\BusinessRegisterRequest;
use App\Offers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Rules\BlacklistWords;

class PostController extends Controller
{
    public function postCreateForm()
    {
        $id = session()->get('id');

        $business = Business::where('id', $id)->with('business_meta')->first();
        $categories = Category::all();
        
        if (session()->get('role_id') == '90' || is_null(session()->get('role_id'))) {
            $offers = Offers::whereIdBusiness($id)
                ->where('expirated_at', '>=', Carbon::now())
                ->count();

            if ($offers >  0) {
                return back()->with('message', ['danger', "Membresía gratis. Usted tiene $offers avisos. Ya no puede publicar mas"]);
            }
        }
        if (session()->get('id')) {
            return view('posts.create')->with(compact('business', 'categories'));
        }
    }

    public function register(BusinessRegisterRequest $request)
    {
        $request->validate([
            'description' => ['required', new BlacklistWords()],
        ]);

        
        $business = new Business;
        $businessMeta = new BusinessMeta;

        $business->rut_user = $request->userRut;
        $business->password = Hash::make($request->password);
        $business->firstname = $request->firstname;
        $business->surname = $request->surname;
        $business->email = $request->email;
        $business->position = $request->position;
        $business->phone = $request->userPhone;

        $business->save();

        $businessMeta->id_business = $business->id;
        $businessMeta->rut_business = $request->rut;
        $businessMeta->business_name = $request->business_name;
        $businessMeta->fantasy_name = $request->fantasy_name;
        $businessMeta->activity = $request->activity;
        $businessMeta->address = $request->address;
        $businessMeta->country = $request->country;
        $businessMeta->state = $request->state;
        $businessMeta->city = $request->city;
        $businessMeta->comune = $request->comune;
        $businessMeta->phone = $request->phone;
        $businessMeta->employees = $request->employees;

        $businessMeta->save();

        session()->flush();
        session([
            'id' => $business->id,
            'name' => $businessMeta->business_name,
            'role' => 'Business'
        ]);

        return back()->with('message', ['success', 'Empresa Creada']);
    }
}
