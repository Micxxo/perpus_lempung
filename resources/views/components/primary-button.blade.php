<button {{ $attributes->merge(['class' => 'bg-primary text-black font-semibold']) }} type="{{ $type ?? 'button' }}"
    @click="{{ $onClick ?? '' }}">
    {{ $slot }}
</button>
