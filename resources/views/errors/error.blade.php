@php
    $error = match ($status) {
        403 => [
            'eyebrow' => 'Access restricted',
            'title' => 'This space is private.',
            'message' => 'You do not have permission to view this page. Please return to a safe place and continue exploring.',
        ],
        419 => [
            'eyebrow' => 'Session expired',
            'title' => 'Let’s try that again.',
            'message' => 'Your session has expired. Refresh the page and submit the form once more.',
        ],
        429 => [
            'eyebrow' => 'Slow down a little',
            'title' => 'Too many requests.',
            'message' => 'We are taking a short pause to protect the experience for everyone. Please try again in a moment.',
        ],
        500 => [
            'eyebrow' => 'A little hiccup',
            'title' => 'Something went wrong.',
            'message' => 'Our team has been notified. Please try again, or return to the homepage while we take a look.',
        ],
        503 => [
            'eyebrow' => 'Be right back',
            'title' => 'We are making things better.',
            'message' => 'Kembang Hijab is temporarily unavailable for maintenance. Please check back shortly.',
        ],
        default => [
            'eyebrow' => 'Page not found',
            'title' => 'This page took a different turn.',
            'message' => 'The page you are looking for may have moved, or the link may no longer be available.',
        ],
    };
@endphp

@extends('errors.layout')

@section('title', $error['title'])

@section('content')
    <section class="w-full max-w-3xl">
        <div class="kh-glass relative overflow-hidden rounded-[2.5rem] px-8 py-12 text-center sm:px-16 sm:py-16">
            <div class="pointer-events-none absolute -right-20 -top-24 h-64 w-64 rounded-full bg-[#e8cfcf]/60 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-24 -left-20 h-64 w-64 rounded-full bg-[#b99a62]/20 blur-3xl"></div>

            <div class="relative">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold tracking-[.18em] text-[#6f5146]">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#6f5146] text-white">K</span>
                    KEMBANG HIJAB
                </a>

                <p class="mt-12 text-7xl font-semibold tracking-[-.08em] text-[#b99a62] sm:text-9xl">
                    {{ $status }}
                </p>
                <p class="mt-5 text-xs font-semibold uppercase tracking-[.28em] text-[#b99a62]">
                    {{ $error['eyebrow'] }}
                </p>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-[#493b36] sm:text-5xl">
                    {{ $error['title'] }}
                </h1>
                <p class="mx-auto mt-5 max-w-lg text-sm leading-7 text-[#6f5146]/70 sm:text-base">
                    {{ $error['message'] }}
                </p>

                <div class="mt-9 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('home') }}" class="kh-btn kh-btn-primary">
                        Back to homepage <span aria-hidden="true">↗</span>
                    </a>
                    <button type="button" onclick="window.history.back()" class="kh-btn kh-btn-secondary">
                        Go back
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection
