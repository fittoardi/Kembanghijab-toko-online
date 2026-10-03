<header class="sticky top-0 z-50 px-4 pt-4 sm:px-6 lg:px-8">

    <nav class="kh-glass mx-auto max-w-7xl rounded-2xl">

        <div class="flex h-16 items-center justify-between px-4 sm:px-6">

            {{-- Mobile Menu --}}
            <button
                type="button"
                class="flex h-10 w-10 items-center justify-center rounded-full text-[#6f5146] transition hover:bg-white/60 lg:hidden"
                aria-label="Open menu"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.7"
                    stroke="currentColor"
                    class="h-5 w-5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                    />
                </svg>
            </button>

            {{-- Logo --}}
            <a
                href="{{ route('home') }}"
                class="flex items-center gap-2"
            >
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#6f5146] text-sm font-semibold text-white">
                    K
                </div>

                <div class="hidden sm:block">
                    <div class="text-sm font-bold tracking-[0.18em] text-[#6f5146]">
                        KEMBANG
                    </div>

                    <div class="-mt-1 text-[9px] font-medium tracking-[0.32em] text-[#b99a62]">
                        HIJAB
                    </div>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden items-center gap-8 lg:flex">

                <a
                    href="{{ route('home') }}"
                    class="text-sm font-medium text-[#6f5146] transition hover:text-[#b99a62]"
                >
                    Home
                </a>

                <a
                    href="{{ route('products.index') }}"
                    class="text-sm font-medium text-[#6f5146] transition hover:text-[#b99a62]"
                >
                    Shop
                </a>

                <a
                    href="{{ route('collection.index') }}"
                    class="text-sm font-medium text-[#6f5146] transition hover:text-[#b99a62]"
                >
                    Collection
                </a>

                <a
                    href="{{ route('about') }}"
                    class="text-sm font-medium text-[#6f5146] transition hover:text-[#b99a62]"
                >
                    About
                </a>

                <a
                    href="{{ route('contact') }}"
                    class="text-sm font-medium text-[#6f5146] transition hover:text-[#b99a62]"
                >
                    Contact
                </a>

            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-1">

                {{-- Search --}}
                <button
                    type="button"
                    class="flex h-10 w-10 items-center justify-center rounded-full text-[#6f5146] transition hover:bg-white/70"
                    aria-label="Search"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.7"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z"
                        />
                    </svg>
                </button>

                {{-- Wishlist --}}
                <a
                    href="{{ auth()->check() ? route('wishlist.index') : route('login') }}"
                    class="hidden h-10 w-10 items-center justify-center rounded-full text-[#6f5146] transition hover:bg-white/70 sm:flex"
                    aria-label="Wishlist"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.7"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z"
                        />
                    </svg>
                </a>

                {{-- Cart --}}
                <a
                    href="{{ route('cart.index') }}"
                    class="relative flex h-10 w-10 items-center justify-center rounded-full text-[#6f5146] transition hover:bg-white/70"
                    aria-label="Shopping cart"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.7"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 3h1.386a1.5 1.5 0 0 1 1.47 1.2L5.4 6.75m0 0h13.68a1.5 1.5 0 0 1 1.46 1.84l-1.2 6a1.5 1.5 0 0 1-1.47 1.21H8.03a1.5 1.5 0 0 1-1.47-1.2L5.4 6.75Zm2.63 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm10.5 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"
                        />
                    </svg>

                    <span class="absolute right-0 top-0 flex h-4 min-w-4 items-center justify-center rounded-full bg-[#b99a62] px-1 text-[9px] font-bold text-white">
                        0
                    </span>
                </a>

                {{-- Account --}}
                <a
                    href="{{ auth()->check() ? route('profile.index') : route('login') }}"
                    class="hidden h-10 w-10 items-center justify-center rounded-full text-[#6f5146] transition hover:bg-white/70 lg:flex"
                    aria-label="Account"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.7"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"
                        />
                    </svg>
                </a>

            </div>

        </div>

    </nav>

</header>
