@extends('layouts.app')
@section('title', $title.' — Kembang Hijab')
@section('content')
<section class="mx-auto max-w-6xl px-6 pb-24 pt-16 lg:px-8">
    <div class="kh-glass rounded-[2.5rem] p-8 sm:p-12"><p class="text-xs font-semibold uppercase tracking-[.25em] text-[#b99a62]">Kembang Hijab</p><h1 class="mt-3 text-4xl font-semibold tracking-tight text-[#493b36]">{{ $title }}</h1><p class="mt-4 max-w-xl leading-7 text-[#6f5146]/65">{{ $description }}</p><div class="mt-9 grid gap-4 sm:grid-cols-3">@foreach($cards as $card)<div class="rounded-2xl bg-white/55 p-5"><span class="text-2xl text-[#b99a62]">{{ $card[0] }}</span><h2 class="mt-5 font-semibold text-[#493b36]">{{ $card[1] }}</h2><p class="mt-2 text-sm leading-6 text-[#6f5146]/60">{{ $card[2] }}</p></div>@endforeach</div><a href="{{ route('products.index') }}" class="kh-btn kh-btn-primary mt-9">Continue shopping ↗</a></div>
</section>
@endsection
