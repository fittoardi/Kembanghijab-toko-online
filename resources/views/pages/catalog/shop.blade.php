@extends('layouts.app')
@section('title', 'Shop — Kembang Hijab')
@section('content')
<section class="mx-auto max-w-7xl px-6 pb-24 pt-14 lg:px-8">
    <div class="flex flex-col justify-between gap-5 border-b border-[#6f5146]/10 pb-8 sm:flex-row sm:items-end">
        <div><p class="text-xs font-semibold uppercase tracking-[.25em] text-[#b99a62]">The collection</p><h1 class="mt-3 text-4xl font-semibold tracking-tight text-[#493b36]">Find your everyday favourite.</h1><p class="mt-3 text-sm text-[#6f5146]/60">24 pieces designed to move with you.</p></div>
        <div class="flex gap-2"><button class="kh-btn kh-btn-secondary text-xs">Filter <span>⌄</span></button><button class="kh-btn kh-btn-secondary text-xs">Newest <span>⌄</span></button></div>
    </div>
    <div class="mt-8 flex gap-2 overflow-x-auto pb-2 text-sm"><a class="rounded-full bg-[#6f5146] px-4 py-2 text-white" href="{{ route('products.index') }}">All pieces</a>@foreach(['Pashmina','Voal','Square','Inner'] as $category)<a class="whitespace-nowrap rounded-full bg-white/60 px-4 py-2 text-[#6f5146]/70 transition hover:bg-white" href="{{ route('products.index') }}">{{ $category }}</a>@endforeach</div>
    <div class="mt-10 grid grid-cols-2 gap-x-4 gap-y-10 sm:grid-cols-3 lg:grid-cols-4">
        @foreach($products as $product)
            <a href="{{ route('products.show', $product['slug']) }}" class="group">
                <div class="relative aspect-[4/5] overflow-hidden rounded-3xl bg-gradient-to-br {{ $product['color'] }}"><img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy" class="h-full w-full object-cover mix-blend-multiply opacity-85 transition duration-500 group-hover:scale-105">@if($product['tag'])<span class="absolute left-3 top-3 rounded-full bg-white/80 px-3 py-1 text-[10px] font-semibold uppercase tracking-wide text-[#6f5146] backdrop-blur">{{ $product['tag'] }}</span>@endif</div>
                <p class="mt-4 text-[10px] font-medium uppercase tracking-[.16em] text-[#6f5146]/50">{{ $product['category'] }}</p><h2 class="mt-1 truncate text-sm font-semibold text-[#2e2927]">{{ $product['name'] }}</h2><div class="mt-2 flex items-center justify-between"><span class="text-sm font-semibold text-[#6f5146]">Rp{{ number_format($product['price'], 0, ',', '.') }}</span><span class="text-xs text-[#6f5146]/60">★ {{ $product['rating'] }}</span></div>
            </a>
        @endforeach
    </div>
</section>
@endsection
