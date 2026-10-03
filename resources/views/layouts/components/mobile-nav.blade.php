<nav class="fixed bottom-4 left-4 right-4 z-50 lg:hidden">

    <div class="kh-glass mx-auto max-w-md rounded-2xl px-2 py-2">

        <div class="grid grid-cols-5">

            {{-- Home --}}
            <a
                href="{{ route('home') }}"
                class="flex flex-col items-center gap-1 rounded-xl py-2 text-[#6f5146]"
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
                        d="m2.25 12 9.75-9 9.75 9M4.5 10.5v9.75a1.5 1.5 0 0 0 1.5 1.5h3.75v-6h4.5v6H18a1.5 1.5 0 0 0 1.5-1.5V10.5"
                    />
                </svg>

                <span class="text-[10px] font-medium">
                    Home
                </span>
            </a>

            {{-- Shop --}}
            <a
                href="{{ route('products.index') }}"
                class="flex flex-col items-center gap-1 rounded-xl py-2 text-[#6f5146]/60"
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
                        d="M3.75 6.75h16.5l-1.5 13.5H5.25L3.75 6.75ZM8.25 6.75a3.75 3.75 0 0 1 7.5 0"
                    />
                </svg>

                <span class="text-[10px] font-medium">
                    Shop
                </span>
            </a>

            {{-- Wishlist --}}
            <a
                href="{{ route('wishlist.index') }}"
                class="flex flex-col items-center gap-1 rounded-xl py-2 text-[#6f5146]/60"
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

                <span class="text-[10px] font-medium">
                    Wishlist
                </span>
            </a>

            {{-- Cart --}}
            <a
                href="{{ route('cart.index') }}"
                class="relative flex flex-col items-center gap-1 rounded-xl py-2 text-[#6f5146]/60"
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
                        d="M2.25 3h1.386a1.5 1.5 0 0 1 1.47 1.2L5.4 6.75m0 0h13.68a1.5 1.5 0 0 1 1.46 1.84l-1.2 6a1.5 1.5 0 0 1-1.47 1.21H8.03a1.5 1.5 0 0 1-1.47-1.2L5.4 6.75"
                    />
                </svg>

                <span class="text-[10px] font-medium">
                    Cart
                </span>

                <span class="absolute right-5 top-1 flex h-3.5 min-w-3.5 items-center justify-center rounded-full bg-[#b99a62] px-1 text-[8px] font-bold text-white">
                    0
                </span>
            </a>

            {{-- Account --}}
            <a
                href="{{ route('profile.index') }}"
                class="flex flex-col items-center gap-1 rounded-xl py-2 text-[#6f5146]/60"
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

                <span class="text-[10px] font-medium">
                    Account
                </span>
            </a>

        </div>

    </div>

</nav>
