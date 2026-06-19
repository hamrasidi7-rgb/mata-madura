<?php

use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AiFeatureController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/ai/ask', [AiAssistantController::class, 'ask'])->name('ai.ask');
Route::get('/kategori/{category:slug}', [ArticleController::class, 'category'])->name('category.show');
Route::get('/berita/{article:slug}', [ArticleController::class, 'show'])->name('article.show');

/*
|--------------------------------------------------------------------------
| Admin — lindungi dengan middleware auth milikmu (mis. Breeze/Fortify)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    // ->middleware(['auth', 'can:manage-content'])   // <- aktifkan setelah auth terpasang
    ->group(function () {
        Route::post('ai-features/reorder', [AiFeatureController::class, 'reorder'])->name('ai-features.reorder');
        Route::resource('ai-features', AiFeatureController::class)->except(['show']);
        Route::resource('articles', AdminArticleController::class)->except(['show']);
    });
