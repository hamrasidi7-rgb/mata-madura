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

        $sorotanUtama = Article::published()->where('is_featured', true)->first();

        $aspirasi    = Aspirasi::active()->take(9)->get();
        $aspirasiAiTotal = Aspirasi::active()->sum('similar_count');

        return view('home', [
            'categories'      => $categories,
            'budgetItems'     => BudgetItem::active()->get(),
            'sorotanUtama'    => $sorotanUtama,
            'aspirasi'        => $aspirasi,
            'aspirasiAiTotal' => $aspirasiAiTotal,
            'aiFeatures'      => AiFeature::active()->get(),
        ]);
    }
}
