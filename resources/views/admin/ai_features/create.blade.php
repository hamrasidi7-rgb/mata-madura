@extends('admin.layout')

@section('title', 'Tambah Fitur AI')

@section('content')
    <h1 class="font-serif text-[26px] font-semibold text-ink-2 mb-6">Tambah Fitur AI</h1>

    @include('admin.ai_features._form', [
        'action' => route('admin.ai-features.store'),
        'method' => 'POST',
    ])
@endsection
