<?php

namespace App\Http\Controllers;

use App\Models\AiFeature;
use App\Models\Article;
use App\Models\Aspirasi;
use App\Models\AuditHighlight;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::active()->get();
        $latest     = Article::published()->with('category')->take(4)->get();

        return view('home', [
            'categories'  => $categories,
            'latest'      => $latest,
            'highlights'  => AuditHighlight::active()->get(),
            'aspirasi'    => Aspirasi::active()->take(3)->get(),
            'aiFeatures'  => AiFeature::active()->get(),
        ]);
    }
}
