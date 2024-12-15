<div x-data="{ variant: '{{ $variant }}' }" class="rounded-md w-fit {{ $class }}"
    :class="{
        'bg-primary px-2 py-1': variant === 'primary',
        'bg-accent px-2 py-1': variant === 'accent',
        'bg-secondary px-2 py-1': variant === 'secondary'
    }">
    <p class="text-black font-medium">{{ $slot }}</p>
</div>
