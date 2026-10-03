<footer class="border-t border-[#6f5146]/10 bg-white/30">

    <div class="mx-auto max-w-7xl px-6 py-14 lg:px-8">

        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">

            {{-- Brand --}}
            <div class="lg:col-span-1">

                <div class="mb-4">

                    <div class="text-lg font-bold tracking-[0.18em] text-[#6f5146]">
                        KEMBANG
                    </div>

                    <div class="text-[10px] font-medium tracking-[0.35em] text-[#b99a62]">
                        HIJAB
                    </div>

                </div>

                <p class="max-w-xs text-sm leading-6 text-[#6f5146]/65">
                    Elegant hijab for your everyday look.
                    Designed with simplicity, comfort, and timeless beauty.
                </p>

                <div class="mt-5 flex gap-2">

                    <a
                        href="#"
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-white/60 text-[#6f5146] transition hover:bg-[#6f5146] hover:text-white"
                    >
                        IG
                    </a>

                    <a
                        href="#"
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-white/60 text-[#6f5146] transition hover:bg-[#6f5146] hover:text-white"
                    >
                        TT
                    </a>

                </div>

            </div>

            {{-- Shop --}}
            <div>

                <h3 class="mb-4 text-sm font-semibold text-[#6f5146]">
                    Shop
                </h3>

                <ul class="space-y-3 text-sm text-[#6f5146]/65">

                    <li>
                        <a href="{{ route('products.index') }}" class="transition hover:text-[#b99a62]">
                            New Arrivals
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('products.index') }}" class="transition hover:text-[#b99a62]">
                            Best Sellers
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('products.index') }}" class="transition hover:text-[#b99a62]">
                            Pashmina
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('products.index') }}" class="transition hover:text-[#b99a62]">
                            Square
                        </a>
                    </li>

                </ul>

            </div>

            {{-- Help --}}
            <div>

                <h3 class="mb-4 text-sm font-semibold text-[#6f5146]">
                    Help
                </h3>

                <ul class="space-y-3 text-sm text-[#6f5146]/65">

                    <li>
                        <a href="{{ route('help.index') }}" class="transition hover:text-[#b99a62]">
                            FAQ
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('help.index') }}" class="transition hover:text-[#b99a62]">
                            Shipping
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('help.index') }}" class="transition hover:text-[#b99a62]">
                            Contact
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('orders.index') }}" class="transition hover:text-[#b99a62]">
                            Order Tracking
                        </a>
                    </li>

                </ul>

            </div>

            {{-- Newsletter --}}
            <div>

                <h3 class="mb-4 text-sm font-semibold text-[#6f5146]">
                    Stay in Bloom
                </h3>

                <p class="mb-4 text-sm leading-6 text-[#6f5146]/65">
                    Get updates about new collections and special offers.
                </p>

                <form class="flex gap-2">

                    <input
                        type="email"
                        placeholder="Your email"
                        class="min-w-0 flex-1 rounded-full border border-[#6f5146]/10 bg-white/60 px-4 py-2.5 text-sm outline-none focus:border-[#6f5146]/30"
                    >

                    <button
                        type="submit"
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#6f5146] text-white transition hover:bg-[#5e433a]"
                    >
                        →
                    </button>

                </form>

            </div>

        </div>

        <div class="mt-12 border-t border-[#6f5146]/10 pt-6 text-center text-xs text-[#6f5146]/50">
            © {{ date('Y') }} Kembang Hijab. All rights reserved.
        </div>

    </div>

</footer>
