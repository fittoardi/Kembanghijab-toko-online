@extends('layouts.app')

@section('title', 'Contact — Kembang Hijab')

@section('content')
    <section class="mx-auto max-w-7xl px-6 pb-24 pt-16 lg:px-8 lg:pt-24">
        <div class="grid gap-12 lg:grid-cols-[.85fr_1.15fr]">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[.3em] text-[#b99a62]">We are here for you</p>
                <h1 class="mt-4 text-5xl font-semibold leading-[1.05] tracking-[-.05em] text-[#493b36] sm:text-6xl">Let’s talk, <span class="font-serif italic font-normal text-[#a17e69]">bloomer.</span></h1>
                <p class="mt-7 max-w-md leading-8 text-[#6f5146]/70">Punya pertanyaan tentang produk, ukuran, atau pesananmu? Tim Kembang siap membantu.</p>
                <div class="mt-10 space-y-5">
                    <a href="https://wa.me/6281234567890" class="flex items-center gap-4 text-sm text-[#6f5146] transition hover:text-[#b99a62]"><span class="flex h-11 w-11 items-center justify-center rounded-full bg-[#e8cfcf] text-lg">◌</span><span><strong class="block text-[#493b36]">WhatsApp</strong><span class="text-[#6f5146]/60">Chat with our team</span></span></a>
                    <a href="mailto:hello@kembanghijab.com" class="flex items-center gap-4 text-sm text-[#6f5146] transition hover:text-[#b99a62]"><span class="flex h-11 w-11 items-center justify-center rounded-full bg-[#e9ded2] text-lg">✉</span><span><strong class="block text-[#493b36]">Email</strong><span class="text-[#6f5146]/60">hello@kembanghijab.com</span></span></a>
                    <div class="flex items-center gap-4 text-sm text-[#6f5146]"><span class="flex h-11 w-11 items-center justify-center rounded-full bg-[#d8cde0] text-lg">⌖</span><span><strong class="block text-[#493b36]">Studio hours</strong><span class="text-[#6f5146]/60">Mon–Sat, 09:00–17:00 WIB</span></span></div>
                </div>
            </div>
            <form class="kh-glass rounded-[2.5rem] p-7 sm:p-10" action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <h2 class="text-2xl font-semibold text-[#493b36]">Send us a note</h2>
                <p class="mt-2 text-sm text-[#6f5146]/60">We usually reply within one business day.</p>
                @if (session('status'))
                    <div class="mt-5 rounded-2xl bg-[#e8cfcf]/60 px-4 py-3 text-sm text-[#6f5146]">{{ session('status') }}</div>
                @endif
                <div class="mt-7 grid gap-5 sm:grid-cols-2">
                    <label class="text-sm font-medium text-[#493b36]">Name<input class="kh-input mt-2" type="text" name="name" placeholder="Your name"></label>
                    <label class="text-sm font-medium text-[#493b36]">Email<input class="kh-input mt-2" type="email" name="email" placeholder="you@example.com"></label>
                </div>
                <label class="mt-5 block text-sm font-medium text-[#493b36]">Subject<input class="kh-input mt-2" type="text" name="subject" placeholder="How can we help?"></label>
                <label class="mt-5 block text-sm font-medium text-[#493b36]">Message<textarea class="kh-input mt-2 min-h-36 resize-y" name="message" placeholder="Tell us a little more..."></textarea></label>
                <button class="kh-btn kh-btn-primary mt-6 w-full sm:w-auto" type="submit">Send message ↗</button>
            </form>
        </div>
    </section>
@endsection
