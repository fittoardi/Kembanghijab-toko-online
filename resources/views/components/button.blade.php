@props([
    'type' => 'button',
    'variant' => 'primary',
    'href' => null,
])

@php
    $classes = match ($variant) {
        'secondary' => 'kh-btn kh-btn-secondary',
        'outline' => 'kh-btn border border-[#6f5146]/15 bg-transparent text-[#6f5146] hover:bg-white/60',
        'danger' => 'kh-btn bg-red-500 text-white hover:bg-red-600',
        default => 'kh-btn kh-btn-primary',
    };
@endphp

@if($href)

    <a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => $classes]) }}
    >
        {{ $slot }}
    </a>

@else

    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $classes]) }}
    >
        {{ $slot }}
    </button>

@endif
