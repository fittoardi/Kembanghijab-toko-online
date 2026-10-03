@props([
    'variant' => 'default',
])

@php
    $classes = match ($variant) {
        'success' => 'bg-green-100 text-green-700',
        'warning' => 'bg-yellow-100 text-yellow-700',
        'danger' => 'bg-red-100 text-red-700',
        'gold' => 'bg-[#b99a62]/15 text-[#8f733f]',
        'pink' => 'bg-[#e8cfcf] text-[#6f5146]',
        default => 'bg-white/70 text-[#6f5146]',
    };
@endphp

<span {{ $attributes->merge([
    'class' => "inline-flex items-center rounded-full px-3 py-1.5 text-xs font-semibold {$classes}"
]) }}>
    {{ $slot }}
</span>
