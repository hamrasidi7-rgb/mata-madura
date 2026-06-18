<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiFeature;
use Illuminate\Http\Request;

class AiFeatureController extends Controller
{
    public function index()
    {
        $features = AiFeature::orderBy('sort_order')->get();

        return view('admin.ai_features.index', compact('features'));
    }

    public function create()
    {
        return view('admin.ai_features.create', [
            'feature' => new AiFeature(['is_active' => true, 'icon' => 'sparkles']),
        ]);
    }

    public function store(Request $request)
    {
        AiFeature::create($this->validated($request));

        return redirect()->route('admin.ai-features.index')
            ->with('status', 'Fitur AI ditambahkan.');
    }

    public function edit(AiFeature $aiFeature)
    {
        return view('admin.ai_features.edit', ['feature' => $aiFeature]);
    }

    public function update(Request $request, AiFeature $aiFeature)
    {
        $aiFeature->update($this->validated($request));

        return redirect()->route('admin.ai-features.index')
            ->with('status', 'Fitur AI diperbarui.');
    }

    public function destroy(AiFeature $aiFeature)
    {
        $aiFeature->delete();

        return redirect()->route('admin.ai-features.index')
            ->with('status', 'Fitur AI dihapus.');
    }

    /** Urut ulang via drag (terima array id berurutan). */
    public function reorder(Request $request)
    {
        $ids = $request->validate(['ids' => ['required', 'array']])['ids'];

        foreach ($ids as $order => $id) {
            AiFeature::whereKey($id)->update(['sort_order' => $order + 1]);
        }

        return response()->json(['ok' => true]);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title'        => ['required', 'string', 'max:120'],
            'description'  => ['required', 'string', 'max:255'],
            'icon'         => ['required', 'string', 'max:40'],
            'route_or_url' => ['nullable', 'string', 'max:255'],
            'sort_order'   => ['nullable', 'integer', 'min:0'],
            'is_active'    => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}
