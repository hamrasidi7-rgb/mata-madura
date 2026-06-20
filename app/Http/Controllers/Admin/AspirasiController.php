<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    public function index(Request $request)
    {
        $mod   = $request->get('mod', 'pending');
        $query = Aspirasi::where('moderation_status', $mod);

        // Pending: terlama dulu (biar tidak terlewat)
        $query = $mod === 'pending'
            ? $query->oldest('submitted_at')
            : $query->latest('submitted_at');

        $aspirasi = $query->paginate(20)->withQueryString();

        $counts = [
            'pending'  => Aspirasi::where('moderation_status', 'pending')->count(),
            'approved' => Aspirasi::where('moderation_status', 'approved')->count(),
            'rejected' => Aspirasi::where('moderation_status', 'rejected')->count(),
        ];

        return view('admin.aspirasi.index', compact('aspirasi', 'counts', 'mod'));
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

    /** Setujui — aspirasi tampil di homepage. */
    public function approve(Aspirasi $aspirasi)
    {
        $aspirasi->update([
            'moderation_status' => 'approved',
            'moderated_at'      => now(),
            'moderated_by'      => auth()->id(),
            'rejection_reason'  => null,
            'is_active'         => true,
        ]);

        return back()->with('success', 'Aspirasi disetujui dan kini tampil di beranda.');
    }

    /** Tolak — tidak tampil di homepage, alasan tersimpan. */
    public function reject(Request $request, Aspirasi $aspirasi)
    {
        $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:255'],
        ]);

        $aspirasi->update([
            'moderation_status' => 'rejected',
            'moderated_at'      => now(),
            'moderated_by'      => auth()->id(),
            'rejection_reason'  => $request->rejection_reason,
            'is_active'         => false,
        ]);

        return back()->with('success', 'Aspirasi ditolak dan tidak ditampilkan di beranda.');
    }

    /** Kembalikan ke antrian pending. */
    public function setPending(Aspirasi $aspirasi)
    {
        $aspirasi->update([
            'moderation_status' => 'pending',
            'moderated_at'      => null,
            'moderated_by'      => null,
            'rejection_reason'  => null,
            'is_active'         => false,
        ]);

        return back()->with('success', 'Aspirasi dikembalikan ke antrian moderasi.');
    }

    /** Ganti status penanganan cepat (hanya untuk approved). */
    public function updateStatus(Request $request, Aspirasi $aspirasi)
    {
        $request->validate(['status' => ['required', 'in:baru,ditanggapi,selesai']]);
        $aspirasi->update(['status' => $request->status]);

        return back()->with('success', 'Status penanganan diperbarui.');
    }

    /** Toggle tampil/sembunyikan di homepage (hanya berlaku untuk approved). */
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
