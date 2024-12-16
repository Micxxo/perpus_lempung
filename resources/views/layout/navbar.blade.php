<nav class="flex items-center w-full justify-between rounded-full shadow-blur-xs bg-white px-7 py-2 ">

    {{-- fixed z-10 top-0 left-0 right-0 mx-auto --}}
    <a href="/">
        <div class="w-6 md:w-7 h-7 md:h-9">
            <img src="{{ asset('images/logo.webp') }}" alt="Logo" />
        </div>
    </a>

    <div class="hidden md:flex items-center gap-4">
        {{-- dekstop  --}}
        <ul class="flex items-center gap-4">
            <li><a href="#home">Beranda</a></li>
            <li><a href="#collection">Koleksi</a></li>
        </ul>
        <a href="/login">
            <x-primary-button
                class="rounded-full px-10 py-1 text-base hover:bg-primary/90 duration-200">Login</x-primary-button>
        </a>
    </div>

    {{-- mobile  --}}
    <x-dropdown position="left" class="!px-2 !py-1" panelClass="mt-3" containerClass="!flex md:!hidden">
        <x-slot name="buttonSlot">
            <span class="material-symbols-outlined">
                menu
            </span>
        </x-slot>


        <x-slot name="contentSlot">
            <ul class="">
                <li><a href="#home"
                        class="px-2 lg:py-1.5 py-2 w-full flex items-center rounded-md transition-colors text-left text-gray-800 hover:bg-gray-50">Beranda</a>
                </li>
                <li><a href="#collection"
                        class="px-2 lg:py-1.5 py-2 w-full flex items-center rounded-md transition-colors text-left text-gray-800 hover:bg-gray-50">Koleksi</a>
                </li>
                <li><a href="/login"
                        class="px-2 lg:py-1.5 py-2 w-full flex items-center rounded-md transition-colors text-left bg-primary">Login</a>
                </li>
            </ul>
        </x-slot>
    </x-dropdown>
</nav>
