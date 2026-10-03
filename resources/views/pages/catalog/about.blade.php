@extends('layouts.app')

@section('title', 'About — Kembang Hijab')

@section('content')
    <section class="mx-auto max-w-7xl px-6 pb-20 pt-16 lg:px-8 lg:pt-24">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[.3em] text-[#b99a62]">Our story</p>
                <h1 class="mt-4 text-5xl font-semibold leading-[1.05] tracking-[-.05em] text-[#493b36] sm:text-7xl">
                    Designed for your <span class="font-serif italic font-normal text-[#a17e69]">everyday bloom.</span>
                </h1>
                <p class="mt-7 max-w-xl text-base leading-8 text-[#6f5146]/70">
                    Kembang Hijab lahir dari hal sederhana: keinginan untuk membuat hijab yang terasa indah, nyaman, dan dekat dengan kehidupan sehari-hari.
                </p>
            </div>
            <div class="kh-glass-dark rounded-[2.5rem] p-8 text-white sm:p-12">
                <span class="text-5xl text-[#e6c996]">“</span>
                <p class="mt-4 text-2xl font-medium leading-relaxed">Hijab yang baik bukan hanya melengkapi penampilan, tapi memberi ruang untuk menjadi diri sendiri.</p>
                <p class="mt-8 text-xs uppercase tracking-[.2em] text-white/55">The Kembang belief</p>
            </div>
        </div>
    </section>

    <section class="bg-white/30">
        <div class="mx-auto grid max-w-7xl gap-5 px-6 py-20 sm:grid-cols-3 lg:px-8">
            @foreach([
                ['✦', 'Thoughtful fabrics', 'Kami memilih material yang lembut, ringan, dan nyaman untuk menemani ritme harianmu.'],
                ['♡', 'Made with care', 'Setiap detail dirancang dengan perhatian agar kualitasnya terasa sejak pertama dipakai.'],
                ['◎', 'Less, but better', 'Koleksi yang timeless, mudah dipadukan, dan dibuat untuk dipakai berulang kali.'],
            ] as $value)
                <div class="kh-card p-7"><span class="text-3xl text-[#b99a62]">{{ $value[0] }}</span><h2 class="mt-8 text-xl font-semibold text-[#493b36]">{{ $value[1] }}</h2><p class="mt-3 text-sm leading-7 text-[#6f5146]/65">{{ $value[2] }}</p></div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-3xl px-6 py-24 text-center lg:px-8">
        <p class="text-xs font-semibold uppercase tracking-[.25em] text-[#b99a62]">Come as you are</p>
        <h2 class="mt-4 text-4xl font-semibold tracking-tight text-[#493b36]">There is beauty in every version of you.</h2>
        <p class="mt-5 leading-8 text-[#6f5146]/65">Terima kasih sudah menjadi bagian dari perjalanan Kembang. Kami percaya gaya tidak harus rumit untuk terasa spesial.</p>
        <a href="{{ route('products.index') }}" class="kh-btn kh-btn-primary mt-8">Explore the collection ↗</a>
    </section>
@endsection
