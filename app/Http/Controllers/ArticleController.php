<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function show(Article $article)
    {
        $article->load('category');

        $readNext = Article::published()
            ->whereKeyNot($article->id)
            ->with('category')
            ->take(2)
            ->get();

        return view('article', compact('article', 'readNext'));
    }

    public function category(Category $category)
    {
        $articles = $category->articles()
            ->published()
            ->with('category')
            ->paginate(12);

        return view('category', compact('category', 'articles'));
    }
}
