@extends('admin.layout')

@section('title', 'Ubah Fitur AI')

@section('content')
    <h1 class="font-serif text-[26px] font-semibold text-ink-2 mb-6">Ubah Fitur AI</h1>

    @include('admin.ai_features._form', [
        'action' => route('admin.ai-features.update', $feature),
        'method' => 'PUT',
    ])
@endsection
