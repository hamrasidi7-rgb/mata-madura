<?php

namespace App\Http\Controllers;

use App\Models\AiFeature;
use App\Models\Article;
use App\Models\Aspirasi;
use App\Models\BudgetItem;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::active()->get();

        $aspirasi        = Aspirasi::active()->take(9)->get();
        $aspirasiAiTotal = Aspirasi::active()->sum('similar_count');

        $latest = Article::published()->with('category')->take(4)->get();

        return view('home', [
            'categories'      => $categories,
            'aspirasi'        => $aspirasi,
            'aspirasiAiTotal' => $aspirasiAiTotal,
            'latest'          => $latest,
            'aiFeatures'      => AiFeature::active()->get(),
        ]);
    }
}
