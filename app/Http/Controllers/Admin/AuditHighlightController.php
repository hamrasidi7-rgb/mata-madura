<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditHighlight;
use Illuminate\Http\Request;

class AuditHighlightController extends Controller
{
    public function index()
    {
        $highlights = AuditHighlight::orderBy('order')->get();
        return view('admin.audit_highlights.index', compact('highlights'));
    }

    public function create()
    {
        $highlight = new AuditHighlight(['is_active' => true, 'order' => 0]);
        return view('admin.audit_highlights.create', compact('highlight'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label'     => ['required', 'string', 'max:100'],
            'value'     => ['required', 'string', 'max:50'],
            'order'     => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        AuditHighlight::create($data + ['is_active' => $request->boolean('is_active')]);

        return redirect()->route('admin.audit-highlights.index')
            ->with('success', 'Strip audit berhasil ditambahkan.');
    }

    public function edit(AuditHighlight $auditHighlight)
    {
        return view('admin.audit_highlights.edit', ['highlight' => $auditHighlight]);
    }

    public function update(Request $request, AuditHighlight $auditHighlight)
    {
        $data = $request->validate([
            'label'     => ['required', 'string', 'max:100'],
            'value'     => ['required', 'string', 'max:50'],
            'order'     => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $auditHighlight->update($data + ['is_active' => $request->boolean('is_active')]);

        return redirect()->route('admin.audit-highlights.index')
            ->with('success', 'Strip audit berhasil diperbarui.');
    }

    public function destroy(AuditHighlight $auditHighlight)
    {
        $auditHighlight->delete();

        return redirect()->route('admin.audit-highlights.index')
            ->with('success', 'Strip audit berhasil dihapus.');
    }
}
