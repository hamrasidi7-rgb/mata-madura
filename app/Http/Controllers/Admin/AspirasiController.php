<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Aspirasi::latest('submitted_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $aspirasi = $query->paginate(20)->withQueryString();

        $counts = [
            'all'         => Aspirasi::count(),
            'baru'        => Aspirasi::where('status', 'baru')->count(),
            'ditanggapi'  => Aspirasi::where('status', 'ditanggapi')->count(),
            'selesai'     => Aspirasi::where('status', 'selesai')->count(),
        ];

        return view('admin.aspirasi.index', compact('aspirasi', 'counts'));
    }

    public function edit(Aspirasi $aspirasi)
    {
        return view('admin.aspirasi.edit', compact('aspirasi'));
    }

    public function update(Request $request, Aspirasi $aspirasi)
    {
        $data = $request->validate([
            'title'     => ['required', 'string', 'max:255'],
            'location'  => ['nullable', 'string', 'max:100'],
            'color'     => ['required', 'in:green,yellow,blue,red'],
            'status'    => ['required', 'in:baru,ditanggapi,selesai'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $aspirasi->update($data + ['is_active' => $request->boolean('is_active')]);

        return redirect()->route('admin.aspirasi.index')
            ->with('success', 'Aspirasi berhasil diperbarui.');
    }

    /** Ganti status cepat langsung dari daftar. */
    public function updateStatus(Request $request, Aspirasi $aspirasi)
    {
        $request->validate(['status' => ['required', 'in:baru,ditanggapi,selesai']]);

        $aspirasi->update(['status' => $request->status]);

        return back()->with('success', 'Status aspirasi diperbarui.');
    }

    /** Toggle tampil/sembunyikan di homepage. */
    public function toggle(Aspirasi $aspirasi)
    {
        $aspirasi->update(['is_active' => ! $aspirasi->is_active]);

        $label = $aspirasi->is_active ? 'ditampilkan' : 'disembunyikan';
        return back()->with('success', "Aspirasi {$label} dari beranda.");
    }

    public function destroy(Aspirasi $aspirasi)
    {
        $aspirasi->delete();

        return redirect()->route('admin.aspirasi.index')
            ->with('success', 'Aspirasi berhasil dihapus.');
    }
}
