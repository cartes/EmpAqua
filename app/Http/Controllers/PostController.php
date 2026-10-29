<?php

namespace App\Http\Controllers;

use App\Enums\Membership;
use App\Models\Business;
use App\Models\Category;
use App\Models\Offers;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    public function postCreateForm(): View|RedirectResponse
    {
        $id = session('id');

        $isFree = in_array(Membership::fromSession(session('role_id')), [null, Membership::Free], true);

        if ($isFree) {
            $active = Offers::where('id_business', $id)->where('expirated_at', '>=', now())->count();

            if ($active > 0) {
                return back()->with('message', ['danger', "Membresía gratis. Usted tiene $active avisos. Ya no puede publicar mas"]);
            }
        }

        return view('posts.create', [
            'business' => Business::with('business_meta')->find($id),
            'categories' => Category::all(),
        ]);
    }
}
