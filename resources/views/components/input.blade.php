@props([
    'label' => null,
    'name',
    'type' => 'text',
    'placeholder' => '',
])

<div class="space-y-2">

    @if($label)
        <label
            for="{{ $name }}"
            class="block text-sm font-medium text-[#6f5146]"
        >
            {{ $label }}
        </label>
    @endif

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name) }}"
        {{ $attributes->merge([
            'class' => 'kh-input'
        ]) }}
    >

    @error($name)
        <p class="text-xs text-red-500">
            {{ $message }}
        </p>
    @enderror

</div>
