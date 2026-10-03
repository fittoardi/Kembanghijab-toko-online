@props([
    'name' => 'quantity',
    'value' => 1,
    'min' => 1,
    'max' => 99,
])

<div
    x-data="{ quantity: {{ $value }} }"
    class="inline-flex items-center rounded-full border border-[#6f5146]/10 bg-white/60 p-1"
>

    <button
        type="button"
        @click="quantity = Math.max({{ $min }}, quantity - 1)"
        class="flex h-9 w-9 items-center justify-center rounded-full text-[#6f5146] transition hover:bg-white"
    >
        −
    </button>

    <input
        type="number"
        name="{{ $name }}"
        x-model="quantity"
        min="{{ $min }}"
        max="{{ $max }}"
        class="w-12 border-0 bg-transparent text-center text-sm font-semibold text-[#6f5146] outline-none"
    >

    <button
        type="button"
        @click="quantity = Math.min({{ $max }}, quantity + 1)"
        class="flex h-9 w-9 items-center justify-center rounded-full text-[#6f5146] transition hover:bg-white"
    >
        +
    </button>

</div>
