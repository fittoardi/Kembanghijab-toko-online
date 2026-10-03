<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Kembang Hijab')
    </title>

    <meta
        name="description"
        content="@yield('meta_description', 'Kembang Hijab — Elegant hijab for your everyday look.')"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')
</head>

<body class="min-h-screen antialiased">

    {{-- Announcement Bar --}}
    <div class="bg-[#6f5146] px-4 py-2 text-center text-xs font-medium tracking-wide text-white">
        Free shipping for selected orders · Discover the latest collection
    </div>

    {{-- Navbar --}}
    @include('layouts.components.navbar')

    {{-- Main --}}
    <main class="min-h-screen pb-20 lg:pb-0">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.components.footer')

    {{-- Mobile Navigation --}}
    @include('layouts.components.mobile-nav')

    @stack('scripts')

</body>

</html>
