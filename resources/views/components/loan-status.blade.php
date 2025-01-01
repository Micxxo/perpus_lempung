<div x-data="{ variant: '{{ $variant }}' }" class="rounded-full py-1 px-2 w-fit {{ $class }}"
    :class="{
        'bg-emerald-100': variant === 'borrowed',
        'bg-emerald-200': variant === 'returned',
        'bg-red-200': variant === 'late',
        'bg-red-300': variant === 'fine',
        'bg-red-100': variant === 'deadline',
        'bg-primary': variant === 'all',
    }"
    class="">
    <p class="text-xs "
        :class="{
            'text-green-600': variant === 'borrowed',
            'text-green-800': variant === 'returned',
            'text-red-600': variant === 'late',
            'text-red-800': variant === 'fine',
            'text-red-700': variant === 'deadline',
            'text-black': variant === 'all',
        }"
        x-text="{
            borrowed: 'Dipinjam',
            returned: 'Dikembalikan',
            late: 'Terlambat',
            fine: 'Denda',
            deadline: 'Deadline',
            all: 'Semua',
        }[variant] || 'Status Tidak Dikenal'">
    </p>
</div>
