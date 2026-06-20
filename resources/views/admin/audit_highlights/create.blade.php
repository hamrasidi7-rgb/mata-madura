@extends('admin.layout')
@section('title', 'Tambah Strip Audit')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.audit-highlights.index') }}"
       class="text-[13px] text-muted hover:text-accent">← Kembali</a>
    <h1 class="font-serif text-[26px] font-semibold text-ink-2 mt-1">Tambah Strip Audit</h1>
</div>

@include('admin.audit_highlights._form', [
    'action'    => route('admin.audit-highlights.store'),
    'method'    => 'POST',
    'highlight' => $highlight,
])
@endsection
