@extends('admin.layout')
@section('title', 'Edit Strip Audit')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.audit-highlights.index') }}"
       class="text-[13px] text-muted hover:text-accent">← Kembali</a>
    <h1 class="font-serif text-[26px] font-semibold text-ink-2 mt-1">Edit Strip Audit</h1>
</div>

@include('admin.audit_highlights._form', [
    'action'    => route('admin.audit-highlights.update', $highlight),
    'method'    => 'PUT',
    'highlight' => $highlight,
])
@endsection
