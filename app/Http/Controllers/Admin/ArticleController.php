<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('category')->latest();

        if ($request->filled('status')) {
            match ($request->status) {
                'published' => $query->whereNotNull('published_at'),
                'draft'     => $query->whereNull('published_at'),
                default     => null,
            };
        }

        if ($request->filled('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        $articles = $query->paginate(15)->withQueryString();
        $counts   = [
            'all'       => Article::count(),
            'published' => Article::whereNotNull('published_at')->count(),
            'draft'     => Article::whereNull('published_at')->count(),
        ];

        return view('admin.articles.index', compact('articles', 'counts'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'deck'         => ['nullable', 'string'],
            'body'         => ['required', 'string'],
            'category_id'  => ['required', 'exists:categories,id'],
            'author'       => ['nullable', 'string', 'max:100'],
            'read_minutes' => ['nullable', 'integer', 'min:1', 'max:60'],
            'is_trending'  => ['nullable', 'boolean'],
            'is_featured'  => ['nullable', 'boolean'],
            'image'        => ['nullable', 'image', 'max:2048'],
            'status'       => ['required', 'in:draft,published'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('articles', 'public');
        }

        $data['published_at'] = $data['status'] === 'published' ? now() : null;
        $data['is_trending']  = $request->boolean('is_trending');
        $data['is_featured']  = $request->boolean('is_featured');

        unset($data['status'], $data['image']);

        Article::create($data);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit(Article $article)
    {
        $categories = Category::active()->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'slug'         => ['nullable', 'string', 'max:255'],
            'deck'         => ['nullable', 'string'],
            'body'         => ['required', 'string'],
            'category_id'  => ['required', 'exists:categories,id'],
            'author'       => ['nullable', 'string', 'max:100'],
            'read_minutes' => ['nullable', 'integer', 'min:1', 'max:60'],
            'is_trending'  => ['nullable', 'boolean'],
            'is_featured'  => ['nullable', 'boolean'],
            'image'        => ['nullable', 'image', 'max:2048'],
            'status'       => ['required', 'in:draft,published'],
        ]);

        if ($request->hasFile('image')) {
            if ($article->image_path) {
                Storage::disk('public')->delete($article->image_path);
            }
            $data['image_path'] = $request->file('image')->store('articles', 'public');
        }

        // Published_at: set saat pertama kali publish, biarkan jika sudah ada
        if ($data['status'] === 'published') {
            $data['published_at'] = $article->published_at ?? now();
        } else {
            $data['published_at'] = null;
        }

        // Slug: pakai input user jika diisi, jika kosong biarkan model auto-generate
        if (empty($data['slug'])) {
            $article->slug = '';
        } else {
            $data['slug'] = $data['slug'];
        }

        $data['is_trending'] = $request->boolean('is_trending');
        $data['is_featured'] = $request->boolean('is_featured');

        unset($data['status'], $data['image']);

        $article->update($data);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if ($article->image_path) {
            Storage::disk('public')->delete($article->image_path);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
