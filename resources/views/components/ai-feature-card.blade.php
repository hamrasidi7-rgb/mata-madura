{{--
    x-ai-feature-card: kartu fitur AI.
    Props: $feature (App\Models\AiFeature)
--}}
@props(['feature'])

@php
    $iconBg = match($feature->icon) {
        'chart'  => 'rgba(201,100,66,0.10)',
        'person' => 'rgba(178,31,36,0.09)',
        default  => 'rgba(40,30,20,0.06)',
    };
@endphp

<a href="{{ $feature->link }}"
   style="display:flex; align-items:center; gap:14px; padding:16px 18px; border:1px solid #e8e3d9; border-radius:16px; background:#fff; box-shadow:0 2px 10px rgba(40,30,20,0.03); text-decoration:none;">

    <span style="flex:0 0 auto; width:46px; height:46px; border-radius:12px; background:{{ $iconBg }}; display:flex; align-items:center; justify-content:center;">
        <x-icon :name="$feature->icon" class="w-6 h-6 text-warm" />
    </span>

    <span style="flex:1; min-width:0;">
        <span style="display:block; font-family:'Fraunces',serif; font-size:17px; font-weight:600; color:#14110f; margin-bottom:3px;">{{ $feature->title }}</span>
        <span style="display:block; font-family:'Inter',sans-serif; font-size:12.5px; line-height:1.45; color:#8a8275;">{{ $feature->description }}</span>
    </span>

    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="flex:0 0 auto;">
        <path d="M9 6l6 6-6 6" stroke="#c8c0b2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</a>
