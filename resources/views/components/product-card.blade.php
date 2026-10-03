@props([
    'product',
])

<article class="group relative">

    {{-- Image --}}
    <div class="relative overflow-hidden rounded-3xl bg-[#e9ded2]">

        <a
            href="{{ route('products.show', $product) }}"
            class="block aspect-[4/5]"
        >

            @if($product->primaryImage?->path)
                <img
                    src="{{ Storage::url($product->primaryImage->path) }}"
                    alt="{{ $product->name }}"
                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                    loading="lazy"
                >
            @else
                <div class="flex h-full items-center justify-center text-[#6f5146]/40">
                    No Image
                </div>
            @endif

        </a>

        {{-- Badge --}}
        @if($product->is_new ?? false)
            <span class="absolute left-4 top-4 rounded-full bg-white/80 px-3 py-1.5 text-[10px] font-semibold uppercase tracking-wide text-[#6f5146] backdrop-blur">
                New
            </span>
        @endif

        {{-- Wishlist --}}
        <button
            type="button"
            class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/75 text-[#6f5146] shadow-sm backdrop-blur transition hover:bg-white hover:text-[#b99a62]"
            aria-label="Add {{ $product->name }} to wishlist"
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
        </button>

    </div>

    {{-- Information --}}
    <div class="px-1 pt-4">

        <div class="mb-1 text-[10px] font-medium uppercase tracking-[0.16em] text-[#6f5146]/50">
            {{ $product->category?->name ?? 'Collection' }}
        </div>

        <a
            href="{{ route('products.show', $product) }}"
            class="block truncate text-sm font-semibold text-[#2e2927] transition hover:text-[#6f5146]"
        >
            {{ $product->name }}
        </a>

        <div class="mt-2 flex items-center justify-between gap-2">

            <div class="flex items-center gap-2">

                @if($product->discount_price ?? false)
                    <span class="text-sm font-semibold text-[#6f5146]">
                        Rp{{ number_format($product->discount_price, 0, ',', '.') }}
                    </span>

                    <span class="text-xs text-[#6f5146]/40 line-through">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </span>
                @else
                    <span class="text-sm font-semibold text-[#6f5146]">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </span>
                @endif

            </div>

            @if(isset($product->average_rating))
                <div class="flex items-center gap-1 text-xs text-[#6f5146]/65">
                    <span>★</span>
                    <span>{{ number_format($product->average_rating, 1) }}</span>
                </div>
            @endif

        </div>

    </div>

</article>
