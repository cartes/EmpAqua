<?php

namespace App\Http\Controllers;

use App\Models\Offers;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $offers = Offers::with(['business', 'businessMeta'])
            ->latest()
            ->paginate(8);

        return view('home', compact('offers'));
    }
}
