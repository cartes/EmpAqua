<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use App\Models\Offers;
use App\Models\Search;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function result(Request $request): View
    {
        $userId = session('id');
        $term = (string) $request->input('query');

        $offers = Offers::where('title', 'LIKE', "%{$term}%")
            ->whereDate('expirated_at', '>=', now())
            ->where('published', 1)
            ->paginate(25);

        $postuled = $offers->isNotEmpty()
            && Candidates::where('id_user', $userId)->where('id_offer', $offers->first()->id)->exists();

        $search = Search::firstOrNew(['search_term' => $term, 'user_id' => $userId]);
        $search->quantity = ($search->quantity ?? 0) + 1;
        $search->save();

        return view('search.results', [
            'postuled' => $postuled,
            'offers' => $offers,
            'search' => $term,
            'featured' => null,
        ]);
    }
}
