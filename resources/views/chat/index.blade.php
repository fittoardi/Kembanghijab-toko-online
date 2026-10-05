@extends('layouts.app')

@section('title', 'Customer care — Kembang Hijab')
@section('meta_description', 'Talk to the Kembang Hijab customer care team about products, orders, and delivery.')

@section('content')
    <section class="mx-auto max-w-5xl px-6 pb-24 pt-16 lg:px-8 lg:pt-24">
        <div class="grid overflow-hidden rounded-[2rem] bg-[#6f5146] shadow-xl shadow-[#6f5146]/10 lg:grid-cols-[.8fr_1.2fr]">
            <div class="relative overflow-hidden p-8 text-white sm:p-12">
                <div class="absolute -bottom-16 -right-16 h-64 w-64 rounded-full border border-white/15"></div>
                <p class="relative text-xs font-semibold uppercase tracking-[.3em] text-[#e8cfcf]">Customer care</p>
                <h1 class="relative mt-5 text-4xl font-semibold leading-tight sm:text-5xl">We are here to help.</h1>
                <p class="relative mt-6 max-w-sm leading-7 text-white/70">Tanyakan ukuran, material, order, pembayaran, atau pengiriman. Tim kami siap membantu setiap hari pukul 09.00–18.00.</p>
                <div class="relative mt-10 space-y-4 text-sm text-white/80">
                    <p><span class="mr-3 text-[#e8cfcf]">01</span> Product styling & material</p>
                    <p><span class="mr-3 text-[#e8cfcf]">02</span> Order & payment support</p>
                    <p><span class="mr-3 text-[#e8cfcf]">03</span> Delivery & returns</p>
                </div>
            </div>
            <div class="bg-white/70 p-8 sm:p-12">
                @if(session('status'))
                    <div class="mb-6 rounded-2xl bg-[#e8cfcf]/50 px-4 py-3 text-sm text-[#6f5146]">{{ session('status') }}</div>
                @endif
                <div class="mb-8"><p class="text-xs font-semibold uppercase tracking-[.25em] text-[#b99a62]">Send a message</p><h2 class="mt-2 text-2xl font-semibold text-[#493b36]">How can we help?</h2></div>
                <form method="POST" action="{{ route('chat.submit') }}" class="space-y-5">
                    @csrf
                    <label class="block text-sm font-medium text-[#493b36]">Your message<textarea name="message" rows="5" class="kh-input mt-2 resize-none" placeholder="Tell us what you need help with..."></textarea></label>
                    @error('message')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    <button type="submit" class="kh-btn kh-btn-primary w-full">Send to customer care <span aria-hidden="true">↗</span></button>
                </form>
                <p class="mt-5 text-center text-xs text-[#6f5146]/50">Typical response time: under 2 hours</p>
            </div>
        </div>
    </section>
@endsection
