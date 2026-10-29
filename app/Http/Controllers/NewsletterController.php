<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;

class NewsletterController extends Controller
{
    public function show(): View
    {
        $offersByCategory = Category::with(['Offers' => function ($query) {
            $query->orderByDesc('featured')->orderByDesc('created_at');
        }])->get()->mapWithKeys(fn (Category $category) => [
            $category->title => $category->Offers->take(3),
        ]);

        return view('newsletter.show', compact('offersByCategory'));
    }
}
