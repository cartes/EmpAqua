<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Offers;

class NewsletterController extends Controller
{
    public function show()
    {
        $categories = Category::all();
        
        $offersByCategory = [];
        $cats = [];
        foreach ($categories as $category) {
            $offers = Offers::where('category_id', $category->id)
                ->orderByDesc('featured')
                ->orderByDesc('created_at')
                ->take(3)
                ->get();
                
            $offersByCategory[$category->title] = $offers;
        }

        return view('newsletter.show', compact('offersByCategory'));
    }                
}
