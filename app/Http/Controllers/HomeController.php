<?php

namespace App\Http\Controllers;

use App\Models\AiFeature;
use App\Models\Article;
use App\Models\BudgetItem;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::active()->get();

        $sorotanUtama = Article::published()->where('is_featured', true)->first();

        $trending = Article::published()->where('is_trending', true)
            ->with('category')->take(6)->get();

        $latestQuery = Article::published()->with('category');
        $latestFeatured = (clone $latestQuery)
            ->when($sorotanUtama, fn ($q) => $q->whereKeyNot($sorotanUtama->id))
            ->first();

        $latest = (clone $latestQuery)
            ->when($sorotanUtama, fn ($q) => $q->whereKeyNot($sorotanUtama->id))
            ->when($latestFeatured, fn ($q) => $q->whereKeyNot($latestFeatured->id))
            ->take(4)->get();

        return view('home', [
            'categories'     => $categories,
            'budgetItems'    => BudgetItem::active()->get(),
            'sorotanUtama'   => $sorotanUtama,
            'trending'       => $trending,
            'latestFeatured' => $latestFeatured,
            'latest'         => $latest,
            'aiFeatures'     => AiFeature::active()->get(),
        ]);
    }
}
