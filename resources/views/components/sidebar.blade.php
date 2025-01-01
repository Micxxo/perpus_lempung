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

        @auth
            @if (Auth::user()->role_id !== 3)
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
            @endauth
        @endauth


        @auth
            @if (Auth::user()->role_id !== 3)
                <button
                    class="flex items-center gap-2 rounded-lg 
    {{ Request::is('peminjaman') ? 'bg-white shadow-blur-sm' : 'bg-transparent' }}"
                    :class="minimize ? 'py-3 flex items-center justify-center' : 'px-4 py-3'"
                    onclick="window.location='{{ route('peminjaman') }}'">
                    <span
                        class="material-symbols-outlined {{ Request::is('peminjaman') ? ' text-black' : ' text-black/50' }}">
                        book_4
                    </span>
                    <p x-show="!minimize"
                        class="text-sm font-medium {{ Request::is('peminjaman') ? 'font-medium text-black' : ' text-black/50' }}">
                        Peminjaman
                    </p>
                </button>
            @endauth
        @endauth

        @auth
            @if (Auth::user()->role_id === 2)
                <button
                    class="flex items-center gap-2 rounded-lg 
{{ Request::is('kunjungan') ? 'bg-white shadow-blur-sm' : 'bg-transparent' }}"
                    :class="minimize ? 'py-3 flex items-center justify-center' : 'px-4 py-3'"
                    onclick="window.location='{{ route('kunjungan') }}'">
                    <span
                        class="material-symbols-outlined {{ Request::is('kunjungan') ? ' text-black' : ' text-black/50' }}">
                        groups_3
                    </span>
                    <p x-show="!minimize"
                        class="text-sm font-medium {{ Request::is('kunjungan') ? 'font-medium text-black' : ' text-black/50' }}">
                        Kunjungan
                    </p>
                </button>
            @endif
        @endauth

        @auth
            @if (Auth::user()->role_id === 2)
                <button
                    class="flex items-center gap-2 rounded-lg 
{{ Request::is('denda') ? 'bg-white shadow-blur-sm' : 'bg-transparent' }}"
                    :class="minimize ? 'py-3 flex items-center justify-center' : 'px-4 py-3'"
                    onclick="window.location='{{ route('denda') }}'">
                    <span
                        class="material-symbols-outlined {{ Request::is('denda') ? ' text-black' : ' text-black/50' }}">
                        gavel
                    </span>
                    <p x-show="!minimize"
                        class="text-sm font-medium {{ Request::is('denda') ? 'font-medium text-black' : ' text-black/50' }}">
                        Denda
                    </p>
                </button>
            @endif
        @endauth

        @auth
            @if (Auth::user()->role_id !== 1)
                <button
                    class="flex items-center gap-2 rounded-lg 
{{ Request::is('pengguna') ? 'bg-white shadow-blur-sm' : 'bg-transparent' }}"
                    :class="minimize ? 'py-3 flex items-center justify-center' : 'px-4 py-3'"
                    onclick="window.location='{{ route('pengguna') }}'">
                    <span
                        class="material-symbols-outlined {{ Request::is('pengguna') ? ' text-black' : ' text-black/50' }}">
                        group
                    </span>
                    <p x-show="!minimize"
                        class="text-sm font-medium {{ Request::is('pengguna') ? 'font-medium text-black' : ' text-black/50' }}">
                        Pengguna
                    </p>
                </button>
            @endif
        @endauth

        @auth
            @if (Auth::user()->role_id === 3)
                <button
                    class="flex items-center gap-2 rounded-lg 
    {{ Request::is('laporan') || Request::is('laporan/detail/*') ? 'bg-white shadow-blur-sm' : 'bg-transparent' }}"
                    :class="minimize ? 'py-3 flex items-center justify-center' : 'px-4 py-3'"
                    onclick="window.location='{{ route('laporan') }}'">
                    <span
                        class="material-symbols-outlined {{ Request::is('laporan') || Request::is('laporan/detail/*') ? ' text-black' : ' text-black/50' }}">
                        flag
                    </span>
                    <p x-show="!minimize"
                        class="text-sm font-medium {{ Request::is('laporan') || Request::is('laporan/detail/*') ? 'font-medium text-black' : ' text-black/50' }}">
                        Laporan
                    </p>
                </button>
            @endif
        @endauth


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
