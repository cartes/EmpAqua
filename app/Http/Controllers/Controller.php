<?php

namespace App\Http\Controllers;

use App\Offers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index() {
        $offers = Offers::withCount('candidates')
            ->with('business')
            ->with('businessMeta')
            ->latest()
            ->paginate(8);

        return view('home')->with('offers', $offers);
    }
}
