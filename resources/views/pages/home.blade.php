@extends('layouts.app')

@section('title', 'Kembang Hijab — Bloom in your own way')

@section('content')
    <section class="relative overflow-hidden">
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-6 pb-20 pt-16 lg:grid-cols-[1.05fr_.95fr] lg:px-8 lg:pb-28 lg:pt-24">
            <div class="relative z-10 kh-fade-up">
                <p class="mb-5 text-xs font-semibold uppercase tracking-[.3em] text-[#b99a62]">The new everyday essential</p>
                <h1 class="max-w-2xl text-5xl font-semibold leading-[1.04] tracking-[-.05em] text-[#493b36] sm:text-7xl">
                    Bloom in your <span class="font-serif italic text-[#a17e69]">own way.</span>
                </h1>
                <p class="mt-7 max-w-lg text-base leading-8 text-[#6f5146]/70 sm:text-lg">
                    Koleksi hijab yang dibuat untuk menemani langkahmu—ringan, elegan, dan nyaman dari pagi sampai malam.
                </p>
                <div class="mt-9 flex flex-wrap gap-3">
                    <x-button href="{{ route('products.index') }}">Shop the collection <span aria-hidden="true">↗</span></x-button>
                    <x-button href="#story" variant="secondary">Our story</x-button>
                </div>
                <div class="mt-12 flex items-center gap-8 border-t border-[#6f5146]/10 pt-6">
                    <div><strong class="block text-xl text-[#493b36]">4.9/5</strong><span class="text-xs text-[#6f5146]/55">customer rating</span></div>
                    <div><strong class="block text-xl text-[#493b36]">24k+</strong><span class="text-xs text-[#6f5146]/55">happy bloomers</span></div>
                    <div><strong class="block text-xl text-[#493b36]">100%</strong><span class="text-xs text-[#6f5146]/55">premium fabric</span></div>
                </div>
            </div>
            <div class="relative mx-auto w-full max-w-lg lg:max-w-none">
                <div class="absolute -right-8 top-8 h-48 w-48 rounded-full bg-[#e8cfcf]/70 blur-3xl"></div>
                <div class="absolute -bottom-8 left-0 h-56 w-56 rounded-full bg-[#b99a62]/20 blur-3xl"></div>
                <div class="relative aspect-[.86] overflow-hidden rounded-[3rem] bg-gradient-to-br from-[#dfc9c1] via-[#f1e1d8] to-[#a8897d] shadow-2xl shadow-[#6f5146]/15">
                    <img src="{{ $products[0]['image'] }}" alt="Kembang Hijab collection" class="h-full w-full object-cover mix-blend-multiply opacity-90">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#493b36]/45 via-transparent to-white/10"></div>
                    <div class="absolute bottom-6 left-6 right-6 kh-glass rounded-2xl p-4 text-white">
                        <div class="flex items-center justify-between"><span class="text-xs uppercase tracking-[.2em]">Featured edit</span><span>01 / 04</span></div>
                        <p class="mt-2 text-lg font-medium">Moonlight collection</p>
                    </div>
                </div>
                <div class="absolute -left-5 top-12 hidden rounded-2xl bg-white/75 px-4 py-3 text-xs text-[#6f5146] shadow-lg backdrop-blur sm:block"><span class="mr-2 text-[#b99a62]">✦</span> Made to move with you</div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-10 lg:px-8" id="collections">
        <div class="mb-7 flex items-end justify-between"><div><p class="text-xs font-semibold uppercase tracking-[.25em] text-[#b99a62]">Curated for you</p><h2 class="mt-2 text-3xl font-semibold tracking-tight text-[#493b36]">Shop by mood</h2></div><a href="{{ route('products.index') }}" class="hidden text-sm font-semibold text-[#6f5146] sm:block">View all <span>↗</span></a></div>
        <div class="grid gap-4 sm:grid-cols-3">
            @foreach([['name'=>'Soft neutrals','count'=>'12 pieces','class'=>'from-[#e8d9cb] to-[#bca18d]'],['name'=>'Everyday voal','count'=>'18 pieces','class'=>'from-[#e5caca] to-[#b3868c]'],['name'=>'Silk occasion','count'=>'8 pieces','class'=>'from-[#d1c5d4] to-[#8c7994]']] as $collection)
                <a href="{{ route('products.index') }}" class="group relative h-52 overflow-hidden rounded-[2rem] bg-gradient-to-br {{ $collection['class'] }} p-6 transition hover:-translate-y-1 hover:shadow-xl hover:shadow-[#6f5146]/10">
                    <div class="relative z-10"><p class="text-xs font-semibold uppercase tracking-[.18em] text-white/75">{{ $collection['count'] }}</p><h3 class="mt-2 text-2xl font-semibold text-white">{{ $collection['name'] }}</h3><span class="mt-5 inline-block text-sm text-white/80">Explore ↗</span></div>
                    <div class="absolute -bottom-16 -right-8 h-48 w-48 rounded-full border-[28px] border-white/15 transition group-hover:scale-110"></div>
                </a>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-20 lg:px-8" id="featured">
        <div class="mb-8 flex items-end justify-between"><div><p class="text-xs font-semibold uppercase tracking-[.25em] text-[#b99a62]">The edit</p><h2 class="mt-2 text-3xl font-semibold tracking-tight text-[#493b36]">Loved by our community</h2></div><a href="{{ route('products.index') }}" class="text-sm font-semibold text-[#6f5146]">Shop all <span>↗</span></a></div>
        <div class="grid grid-cols-2 gap-x-4 gap-y-10 sm:grid-cols-3 lg:grid-cols-4">
            @foreach($products as $product)
                <a href="{{ route('products.show', $product['slug']) }}" class="group">
                    <div class="relative aspect-[4/5] overflow-hidden rounded-3xl bg-gradient-to-br {{ $product['color'] }}">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy" class="h-full w-full object-cover mix-blend-multiply opacity-85 transition duration-500 group-hover:scale-105">
                        @if($product['tag'])<span class="absolute left-3 top-3 rounded-full bg-white/80 px-3 py-1 text-[10px] font-semibold uppercase tracking-wide text-[#6f5146] backdrop-blur">{{ $product['tag'] }}</span>@endif
                        <span class="absolute bottom-3 right-3 flex h-10 w-10 items-center justify-center rounded-full bg-white/80 text-[#6f5146] opacity-0 shadow-sm backdrop-blur transition group-hover:opacity-100">↗</span>
                    </div>
                    <p class="mt-4 text-[10px] font-medium uppercase tracking-[.16em] text-[#6f5146]/50">{{ $product['category'] }}</p>
                    <h3 class="mt-1 truncate text-sm font-semibold text-[#2e2927]">{{ $product['name'] }}</h3>
                    <p class="mt-2 text-sm font-semibold text-[#6f5146]">Rp{{ number_format($product['price'], 0, ',', '.') }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <section id="story" class="mx-auto grid max-w-7xl gap-8 px-6 py-10 lg:grid-cols-2 lg:px-8">
        <div class="kh-glass-dark overflow-hidden rounded-[2.5rem] p-8 text-white sm:p-12">
            <p class="text-xs font-semibold uppercase tracking-[.25em] text-[#e6c996]">Our philosophy</p>
            <h2 class="mt-5 max-w-md text-4xl font-semibold leading-tight">Small details.<br><span class="font-serif italic font-normal">Big feeling.</span></h2>
            <p class="mt-6 max-w-md text-sm leading-7 text-white/65">Kembang lahir dari keyakinan bahwa hijab yang baik bukan hanya terlihat indah, tapi juga membuatmu merasa nyaman menjadi diri sendiri.</p>
            <a href="#about" class="mt-8 inline-block text-sm font-semibold text-[#e6c996]">Discover our story →</a>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="kh-card flex min-h-48 flex-col justify-end bg-[#f0e3d9] p-6"><span class="text-3xl">✦</span><h3 class="mt-8 font-semibold text-[#493b36]">Thoughtful fabrics</h3><p class="mt-1 text-sm text-[#6f5146]/60">Selected for softness and flow.</p></div>
            <div class="kh-card mt-8 flex min-h-48 flex-col justify-end bg-[#e8cfcf] p-6"><span class="text-3xl">♡</span><h3 class="mt-8 font-semibold text-[#493b36]">Made with care</h3><p class="mt-1 text-sm text-[#6f5146]/60">Designed in Indonesia.</p></div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-24 text-center lg:px-8">
        <p class="text-xs font-semibold uppercase tracking-[.25em] text-[#b99a62]">From our bloomers</p>
        <blockquote class="mx-auto mt-6 max-w-2xl text-3xl font-medium leading-tight tracking-tight text-[#493b36] sm:text-4xl">“Bahannya jatuh banget dan warnanya ternyata lebih cantik dari foto. Jadi hijab andalan setiap hari.”</blockquote>
        <p class="mt-6 text-sm text-[#6f5146]/60">— Alya, verified customer</p>
    </section>
@endsection