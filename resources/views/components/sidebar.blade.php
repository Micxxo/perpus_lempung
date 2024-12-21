<div class="py-5 duration-200" :class="minimize ? 'w-[5%]  relative' : 'w-[15%] '" x-data="{ minimize: false }">
    <div class="flex items-center justify-between px-5 cursor-pointer">
        <img src="{{ asset('images/logo.webp') }}" alt="Logo" class="w-8 h-10" />
        <button @click="minimize = !minimize" class="flex items-center justify-center"
            :class="minimize ? 'absolute -right-5 bg-white p-1 rounded-full' : ''">
            <span class="material-symbols-outlined text-black/50"
                x-text="minimize ? 'left_panel_open' : 'left_panel_close'"
                :style="{ fontSize: minimize ? '16px' : '' }"">
            </span>
        </button>
    </div>

    <div class="flex flex-col px-4 mt-8 gap-y-3">
        <button
            class="flex items-center gap-2  rounded-lg 
        {{ Request::is('buku') ? 'bg-white shadow-blur-sm' : 'bg-transparent' }}"
            :class="minimize ? 'py-3 flex items-center justify-center' : 'px-4 py-3'"
            onclick="window.location='{{ route('buku') }}'">
            <span class="material-symbols-outlined {{ Request::is('buku') ? ' text-black' : ' text-black/50' }}">
                auto_stories
            </span>
            <p x-show="!minimize"
                class="text-sm {{ Request::is('buku') ? 'font-medium text-black' : ' text-black/50' }}">Daftar Buku
            </p>
        </button>

        <button
            class="flex items-center gap-2 rounded-lg 
    {{ Request::is('peminjaman') ? 'bg-white shadow-blur-sm' : 'bg-transparent' }}"
            :class="minimize ? 'py-3 flex items-center justify-center' : 'px-4 py-3'"
            onclick="window.location='{{ route('peminjaman') }}'">
            <span class="material-symbols-outlined {{ Request::is('peminjaman') ? ' text-black' : ' text-black/50' }}">
                book_4
            </span>
            <p x-show="!minimize"
                class="text-sm font-medium {{ Request::is('peminjaman') ? 'font-medium text-black' : ' text-black/50' }}">
                Peminjaman
            </p>
        </button>

        <div class="w-full h-[1px] bg-black/10"></div>

        <form id="logoutForm" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-2 rounded-lg"
                :class="minimize ? 'py-3 flex items-center justify-center' : 'px-4 py-3'">
                <span class="material-symbols-outlined text-red-600">
                    logout
                </span>
                <p x-show="!minimize" class="text-sm font-medium text-red-600">
                    Logout
                </p>
            </button>
        </form>
    </div>
</div>
