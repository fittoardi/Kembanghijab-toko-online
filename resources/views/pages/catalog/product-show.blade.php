@extends('layouts.app')
@section('title', $product['name'].' — Kembang Hijab')
@section('content')
<section class="mx-auto max-w-7xl px-6 pb-24 pt-10 lg:px-8">
    <a href="{{ route('products.index') }}" class="text-sm text-[#6f5146]/60">← Back to collection</a>
    <div class="mt-8 grid gap-10 lg:grid-cols-2">
        <div class="aspect-[.9] overflow-hidden rounded-[2.5rem] bg-gradient-to-br {{ $product['color'] }}"><img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="h-full w-full object-cover mix-blend-multiply opacity-90"></div>
        <div class="flex flex-col justify-center">
            <p class="text-xs font-semibold uppercase tracking-[.25em] text-[#b99a62]">{{ $product['category'] }} · {{ $product['rating'] }} ★ ({{ $product['reviews'] }} reviews)</p>
            <h1 class="mt-4 text-4xl font-semibold tracking-tight text-[#493b36] sm:text-5xl">{{ $product['name'] }}</h1>
            <div class="mt-5 flex items-center gap-3"><strong class="text-2xl text-[#6f5146]">Rp{{ number_format($product['price'], 0, ',', '.') }}</strong>@if($product['old_price'])<del class="text-sm text-[#6f5146]/40">Rp{{ number_format($product['old_price'], 0, ',', '.') }}</del><span class="rounded-full bg-[#e8cfcf] px-3 py-1 text-xs font-semibold text-[#6f5146]">Sale</span>@endif</div>
            <p class="mt-7 max-w-lg leading-8 text-[#6f5146]/70">{{ $product['description'] }}</p>
            <div class="mt-8 border-y border-[#6f5146]/10 py-6"><p class="text-sm font-semibold text-[#493b36]">Choose your colour</p><div class="mt-4 flex gap-3"><button class="h-9 w-9 rounded-full border-2 border-[#6f5146] bg-[#d8c4bd] ring-2 ring-white"></button><button class="h-9 w-9 rounded-full bg-[#e8cfcf]"></button><button class="h-9 w-9 rounded-full bg-[#6f5146]"></button><button class="h-9 w-9 rounded-full bg-[#d7c1b4]"></button></div></div>
            <div class="mt-7 flex gap-3"><div class="flex items-center rounded-full border border-[#6f5146]/15 bg-white/50"><button class="px-4 py-3 text-lg text-[#6f5146]">−</button><span class="px-2 text-sm">1</span><button class="px-4 py-3 text-lg text-[#6f5146]">+</button></div><a href="{{ route('cart.index') }}" class="kh-btn kh-btn-primary flex-1">Add to bag <span>↗</span></a><button class="kh-btn kh-btn-secondary px-4" aria-label="Add to wishlist">♡</button></div>
            <p class="mt-5 text-xs text-[#6f5146]/55">✓ In stock · Free shipping on orders over Rp300.000</p>
        </div>
    </div>
    <div class="mt-24 border-t border-[#6f5146]/10 pt-12"><p class="text-xs font-semibold uppercase tracking-[.25em] text-[#b99a62]">You may also like</p><div class="mt-7 grid grid-cols-2 gap-4 sm:grid-cols-3">@foreach($relatedProducts as $item)<a href="{{ route('products.show', $item['slug']) }}" class="group"><div class="aspect-[4/5] overflow-hidden rounded-3xl bg-gradient-to-br {{ $item['color'] }}"><img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="h-full w-full object-cover mix-blend-multiply opacity-85 transition group-hover:scale-105"></div><p class="mt-3 text-sm font-semibold text-[#493b36]">{{ $item['name'] }}</p><p class="mt-1 text-sm text-[#6f5146]">Rp{{ number_format($item['price'], 0, ',', '.') }}</p></a>@endforeach</div></div>
</section>
@endsection
