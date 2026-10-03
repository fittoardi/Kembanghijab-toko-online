@extends('layouts.app')

@section('title', 'Collection — Kembang Hijab')

@section('content')
    <section class="mx-auto max-w-7xl px-6 pb-16 pt-16 lg:px-8 lg:pt-24">
        <div class="grid items-end gap-8 lg:grid-cols-[1fr_22rem]">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[.3em] text-[#b99a62]">The Kembang edit</p>
                <h1 class="mt-4 max-w-3xl text-5xl font-semibold leading-[1.05] tracking-[-.05em] text-[#493b36] sm:text-7xl">
                    A collection for every <span class="font-serif italic font-normal text-[#a17e69]">version of you.</span>
                </h1>
            </div>
            <p class="max-w-sm text-sm leading-7 text-[#6f5146]/65 lg:pb-2">
                Dari warna netral yang tenang hingga silk dengan kilau istimewa, temukan koleksi yang terasa seperti kamu.
            </p>
        </div>

        <div class="mt-14 grid gap-4 sm:grid-cols-3">
            @foreach([
                ['Soft neutrals', '12 pieces', 'from-[#e8d9cb] to-[#bca18d]', 'Quiet tones for everyday ease.'],
                ['Everyday voal', '18 pieces', 'from-[#e5caca] to-[#b3868c]', 'Light, airy, and always ready.'],
                ['Silk occasion', '8 pieces', 'from-[#d1c5d4] to-[#8c7994]', 'A little glow for your moments.'],
            ] as $collection)
                <a href="{{ route('products.index') }}" class="group relative min-h-64 overflow-hidden rounded-[2.25rem] bg-gradient-to-br {{ $collection[2] }} p-7 transition hover:-translate-y-1 hover:shadow-xl hover:shadow-[#6f5146]/10">
                    <div class="relative z-10 flex h-full flex-col justify-between">
                        <div><p class="text-xs font-semibold uppercase tracking-[.2em] text-white/75">{{ $collection[1] }}</p><h2 class="mt-3 text-3xl font-semibold text-white">{{ $collection[0] }}</h2></div>
                        <p class="max-w-[12rem] text-sm leading-6 text-white/75">{{ $collection[3] }}</p>
                    </div>
                    <div class="absolute -bottom-20 -right-10 h-56 w-56 rounded-full border-[32px] border-white/15 transition duration-500 group-hover:scale-110"></div>
                </a>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
        <div class="mb-8 flex items-end justify-between">
            <div><p class="text-xs font-semibold uppercase tracking-[.25em] text-[#b99a62]">Shop the edit</p><h2 class="mt-2 text-3xl font-semibold tracking-tight text-[#493b36]">Made to be lived in</h2></div>
            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-[#6f5146]">View all ↗</a>
        </div>
        <div class="grid grid-cols-2 gap-x-4 gap-y-10 sm:grid-cols-3 lg:grid-cols-4">
            @foreach($products as $product)
                <a href="{{ route('products.show', $product['slug']) }}" class="group">
                    <div class="relative aspect-[4/5] overflow-hidden rounded-3xl bg-gradient-to-br {{ $product['color'] }}">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy" class="h-full w-full object-cover mix-blend-multiply opacity-85 transition duration-500 group-hover:scale-105">
                        @if($product['tag'])<span class="absolute left-3 top-3 rounded-full bg-white/80 px-3 py-1 text-[10px] font-semibold uppercase tracking-wide text-[#6f5146] backdrop-blur">{{ $product['tag'] }}</span>@endif
                    </div>
                    <p class="mt-4 text-[10px] font-medium uppercase tracking-[.16em] text-[#6f5146]/50">{{ $product['category'] }}</p>
                    <h3 class="mt-1 truncate text-sm font-semibold text-[#2e2927]">{{ $product['name'] }}</h3>
                    <p class="mt-2 text-sm font-semibold text-[#6f5146]">Rp{{ number_format($product['price'], 0, ',', '.') }}</p>
                </a>
            @endforeach
        </div>
    </section>
@endsection
