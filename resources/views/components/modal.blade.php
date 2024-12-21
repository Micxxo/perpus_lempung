<div x-data="{ openModal: false }" class="relative">
    <!-- Trigger Button -->
    <div x-on:click="openModal = !openModal" class="cursor-pointer">
        {!! $buttonSlot ?? '<button class="p-1 bg-primary text-black rounded-md">Open Modal</button>' !!}
    </div>

    <!-- Modal Overlay -->
    <div x-show="openModal" x-cloak x-transition:enter="transition transform ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-[-20%] scale-90"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition transform ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-[-20%] scale-90"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-20">
        <!-- Modal Content -->
        <div x-cloak x-on:click.away="openModal=false"
            class="bg-white min-w-96 max-w-1/2 max-h-[80%] overflow-y-auto rounded-lg shadow-lg p-6 transform transition-transform relative">
            <h2 class="text-lg font-bold mb-4">{!! $title ?? 'Title' !!}</h2>
            <div class="mb-4">
                {!! $contentSlot ?? '<span class="text-black">Modal</span>' !!}

            </div>

            <!-- Close Button -->
            <button @click="openModal = false" class="bg-transparent text-white  absolute right-5 top-5">
                <span class="material-symbols-outlined text-black">
                    close
                </span>
            </button>
        </div>
    </div>
</div>
