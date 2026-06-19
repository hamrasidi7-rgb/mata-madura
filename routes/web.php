<?php

use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AiFeatureController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProfileController;
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
| Admin Auth (terbuka — tidak butuh login)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin Panel (dilindungi auth)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {
        Route::post('ai-features/reorder', [AiFeatureController::class, 'reorder'])->name('ai-features.reorder');
        Route::resource('ai-features', AiFeatureController::class)->except(['show']);
        Route::resource('articles', AdminArticleController::class)->except(['show']);
        Route::resource('categories', AdminCategoryController::class)->except(['show', 'create', 'edit']);
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    });
