@extends('layout.dashboard')

@section('section')
    <div class="p-10 flex flex-col h-full">
        <div class="w-full flex justify-between">
            <x-badge class="px-4 rounded-md">
                <p class="font-medium">Daftar Pengguna</p>
            </x-badge>

            <x-modal title="Tambah Pengguna">
                <x-slot name="buttonSlot">
                    <button type="button" class="px-5 py-1.5 bg-accent text-white font-medium rounded-md">Tambah
                        Pengguna</button>
                </x-slot>

                <x-slot name="contentSlot">
                    @auth
                        @if (Auth::user()->role_id === 3)
                            <form action="{{ route('pengguna.registerUser') }}" method="POST"
                                class="flex flex-col w-full h-[300px] space-y-3" x-data="{ role: '' }">
                                @csrf
                                <div class="flex flex-col gap-y-3 w-full">
                                    <input type="text" placeholder="Username" name="username" required
                                        class="px-1 py-2 rounded-md border border-black/30 w-full" />

                                    <input type="email" placeholder="Email" name="email" required
                                        class="px-1 py-2 rounded-md border border-black/30 w-full" />

                                    <template x-if="role == 1">
                                        <input type="number" placeholder="NISN" name="nisn" required
                                            class="px-1 py-2 rounded-md border border-black/30 w-full" />
                                    </template>

                                    <select name="role" id="user_role" x-model="role"
                                        class="px-1 py-2 rounded-md border border-black/30 w-full">
                                        <option value="">Pilih Role</option>
                                        <option value="1">Siswa</option>
                                        <option value="2">Pengelola</option>
                                        <option value="3">Pengurus</option>
                                    </select>

                                    <div x-data="{ show: false }"
                                        class="w-full flex items-center border border-black/30 rounded-md py-1">
                                        <input class="bg-transparent flex-1 px-1 py-2 focus:outline-none" required
                                            :type="show ? 'text' : 'password'" name="password" placeholder="Password">
                                        <button type="button" @click="show = !show"
                                            class="flex items-center justify-center pr-3">
                                            <span class="material-symbols-outlined"
                                                x-text="show ? 'visibility_off' : 'visibility'"></span>
                                        </button>
                                    </div>

                                    <div x-data="{ show: false }"
                                        class="w-full flex items-center border border-black/30 rounded-md py-1">
                                        <input class="bg-transparent flex-1 px-1 py-2 focus:outline-none" required
                                            :type="show ? 'text' : 'password'" name="password_confirmation"
                                            placeholder="Konfirmasi Password">
                                        <button type="button" @click="show = !show"
                                            class="flex items-center justify-center pr-3">
                                            <span class="material-symbols-outlined"
                                                x-text="show ? 'visibility_off' : 'visibility'"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex-1 flex items-center justify-end w-full">
                                    <button type="submit" class="px-2 py-1 bg-primary rounded-md">Tambah</button>
                                </div>
                            </form>
                        @else
                            <form action="{{ route('pengguna.registerMember') }}" method="POST"
                                class="flex flex-col w-full h-[300px] space-y-3">
                                @csrf
                                <div class="flex flex-col gap-y-3 w-full">
                                    <input type="text" placeholder="Username" name="username" required
                                        class="px-1 py-2 rounded-md border border-black/30 w-full" />

                                    <input type="email" placeholder="Email" name="email" required
                                        class="px-1 py-2 rounded-md border border-black/30 w-full" />

                                    <input type="number" placeholder="NISN" name="nisn" required
                                        class="px-1 py-2 rounded-md border border-black/30 w-full" />

                                    <div x-data="{ show: false }"
                                        class="w-full flex items-center border border-black/30 rounded-md py-1">
                                        <input class="bg-transparent flex-1 px-1 py-2 focus:outline-none" required
                                            :type="show ? 'text' : 'password'" name="password" placeholder="Password">
                                        <button type="button" @click="show = !show"
                                            class="flex items-center justify-center pr-3">
                                            <span class="material-symbols-outlined"
                                                x-text="show ? 'visibility_off' : 'visibility'"></span>
                                        </button>
                                    </div>

                                    <div x-data="{ show: false }"
                                        class="w-full flex items-center border border-black/30 rounded-md py-1">
                                        <input class="bg-transparent flex-1 px-1 py-2 focus:outline-none" required
                                            :type="show ? 'text' : 'password'" name="password_confirmation"
                                            placeholder="Konfirmasi Password">
                                        <button type="button" @click="show = !show"
                                            class="flex items-center justify-center pr-3">
                                            <span class="material-symbols-outlined"
                                                x-text="show ? 'visibility_off' : 'visibility'"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex-1 flex items-center justify-end w-full">
                                    <button type="submit" class="px-2 py-1 bg-primary rounded-md">Tambah</button>
                                </div>
                            </form>
                        @endif
                    @endauth

                </x-slot>
            </x-modal>
        </div>

        <div class="flex-1">
            <div class="container mx-auto p-4 mb-4 h-full flex flex-col" x-data="{ tab: new URLSearchParams(window.location.search).get('tab') ?? 'siswa' }">
                <ul class="flex border-b mt-6">
                    <li class="-mb-px mr-1">
                        <a class="inline-block rounded-t py-2 px-4 font-semibold hover:text-blue-800" href="#"
                            :class="{ 'bg-white text-blue-700 border-l border-t border-r': tab == 'siswa' }"
                            @click.prevent="tab = 'siswa'">Siswa</a>
                    </li>
                    <li class="-mb-px mr-1">
                        <a class="inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" href="#"
                            :class="{ 'bg-white text-blue-700 border-l border-t border-r': tab == 'pengelola' }"
                            @click.prevent="tab = 'pengelola'">Pengelola Perpustakaan</a>
                    </li>
                    @auth
                        @if (Auth::user()->role_id === 3)
                            <li class="-mb-px mr-1">
                                <a class="inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold"
                                    href="#"
                                    :class="{ 'bg-white text-blue-700 border-l border-t border-r': tab == 'pengurus' }"
                                    @click.prevent="tab = 'pengurus'">Pengurus Perpustakaan</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <div class="content bg-white px-4 py-4 border-l border-r border-b pt-4 flex-1 flex flex-col">
                    <div x-show="tab === 'siswa'">
                        <form method="GET" action="{{ route('pengguna') }}"
                            class="w-full flex items-center gap-5 mt-3 flex-1" id="filterStudentsForm">

                            <input type="hidden" name="tab" value="siswa" />

                            {{-- Search input --}}
                            <div class="flex items-center w-1/4 border border-black/30 rounded-md">
                                <input type="text"
                                    class="border-none bg-white flex-1 py-1.5 px-2 rounded-md focus:outline-none placeholder:text-black/50"
                                    placeholder="Cari nama pengguna" name="students_search"
                                    value="{{ old('students_search', $userSearch) }}" />
                                <div class="flex items-center justify-center pr-3">
                                    <span class="material-symbols-outlined" style="font-size: 20px">
                                        search
                                    </span>
                                </div>
                            </div>

                            <select name="member_filter" id="memberSelect"
                                class="rounded-md border border-black/30 focus:outline-none p-2"
                                onchange="this.form.submit()">
                                <option value="">Pilih Status Member</option>
                                <option value="member" {{ $memberFilter == 'member' ? 'selected' : '' }}>Member</option>
                                <option value="not_member" {{ $memberFilter == 'not_member' ? 'selected' : '' }}>Bukan
                                    Member
                                </option>
                            </select>

                            @if ($userSearch || $memberFilter)
                                <button type="button" onclick="resetStudentFilter()"
                                    class="px-8 py-1.5 bg-primary text-black font-semibold rounded-md">Reset</button>
                            @endif
                        </form>

                        @if ($students->isEmpty())
                            <div class="w-full h-full">
                                <x-user-error-state>
                                    <div class="mt-4 md:mt-7">
                                        <p class="font-semibold text-3xl md:text-4xl text-center md:text-left">Data Siswa
                                            <br> tidak
                                            ditemukan
                                        </p>
                                    </div>
                                </x-user-error-state>
                            </div>
                        @else
                            <div class="flex-1 mt-4 overflow-y-auto custom-scrollbar pr-2">
                                <table class="w-full rounded-md">
                                    <thead class="bg-gray-200 rounded-md w-full sticky top-0 z-10">
                                        <th
                                            class="font-semibold border-r border-gray-300 text-left py-2 px-4 rounded-tl-md">
                                            No
                                        </th>
                                        <th class="font-semibold border-r border-gray-300 text-left py-2 px-4">Nama
                                            pengguna
                                        </th>
                                        <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 ">Email
                                        </th>
                                        <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 ">NISN
                                        </th>
                                        <th class="font-semibold text-left py-2 px-4 border-r border-gray-300">Tanggal
                                            Dibuat
                                        </th>
                                        <th class="font-semibold text-left py-2 px-4 border-r border-gray-300">Status
                                            member
                                        </th>
                                        <th class="font-semibold text-left py-2 px-4 rounded-tr-md">Aksi</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $index => $student)
                                            <tr class="border border-gray-100 even:bg-gray-50">
                                                <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                                    <p>{{ $index + $students->firstItem() }}</p>
                                                </td>
                                                <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                                    <p>{{ $student->username }}</p>
                                                </td>
                                                <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                                    <p>{{ $student->email }}</p>
                                                </td>
                                                <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                                    <p>{{ $student->nisn }}</p>
                                                </td>
                                                <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                                    <p>{{ $student->created_at->format('d-m-Y') }}</p>
                                                </td>
                                                <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                                    <p>{{ $student->is_member === 1 ? 'Member' : 'Bukan Member' }}</p>
                                                </td>
                                                <td class="px-4 py-3 text-left border-r border-gray-200">
                                                    {{-- delete  --}}
                                                    <x-modal title="Hapus Data Siswa">
                                                        <x-slot name="buttonSlot">
                                                            <button>
                                                                <span class="material-symbols-outlined text-red-600">
                                                                    delete
                                                                </span>
                                                            </button>
                                                        </x-slot>

                                                        <x-slot name="contentSlot">
                                                            <div class="w-[400px]">
                                                                <p class="text-sm font-medium">Apakah anda yakin akan
                                                                    menghapus
                                                                    data siswa <span
                                                                        class="font-bold">{{ $student->username }}</span>?
                                                                    Data
                                                                    yang dihapus akan hilang dari list</p>

                                                                <form
                                                                    action="{{ route('pengguna.destroy', $student->id) }}"
                                                                    method="POST"
                                                                    class="mt-3 w-full flex items-center justify-end"
                                                                    id="deleteStudentForm">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="bg-red-600 text-white !px-3 !py-1 rounded-md">
                                                                        <p class="text-sm truncate">Hapus</p>
                                                                </form>
                                                                </button>
                                                            </div>
                                                        </x-slot>
                                                    </x-modal>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-8">
                                {{ $students->appends(request()->except('page'))->links('vendor.pagination.default') }}
                            </div>
                        @endif
                    </div>

                    <div x-show="tab === 'pengelola'">
                        <form method="GET" action="{{ route('pengguna') }}"
                            class="w-full flex items-center gap-5 mt-3 flex-1" id="filterManagerForm">

                            <input type="hidden" name="tab" value="pengelola" />

                            {{-- Search input --}}
                            <div class="flex items-center w-1/4 border border-black/30 rounded-md">
                                <input type="text"
                                    class="border-none bg-white flex-1 py-1.5 px-2 rounded-md focus:outline-none placeholder:text-black/50"
                                    placeholder="Cari nama pengguna" name="managers_search"
                                    value="{{ old('managers_search', $managerSearch) }}" />
                                <div class="flex items-center justify-center pr-3">
                                    <span class="material-symbols-outlined" style="font-size: 20px">
                                        search
                                    </span>
                                </div>
                            </div>

                            @if ($managerSearch)
                                <button type="button" onclick="resetManagerFilter()"
                                    class="px-8 py-1.5 bg-primary text-black font-semibold rounded-md">Reset</button>
                            @endif
                        </form>

                        @if ($managers->isEmpty())
                            <div class="w-full h-full">
                                <x-user-error-state>
                                    <div class="mt-4 md:mt-7">
                                        <p class="font-semibold text-3xl md:text-4xl text-center md:text-left">Data
                                            Pengelola
                                            <br> tidak
                                            ditemukan
                                        </p>
                                    </div>
                                </x-user-error-state>
                            </div>
                        @else
                            <div class="flex-1 mt-4 overflow-y-auto custom-scrollbar pr-2">
                                <table class="w-full rounded-md">
                                    <thead class="bg-gray-200 rounded-md w-full sticky top-0 z-10">
                                        <th
                                            class="font-semibold border-r border-gray-300 text-left py-2 px-4 rounded-tl-md">
                                            No
                                        </th>
                                        <th class="font-semibold border-r border-gray-300 text-left py-2 px-4">Nama
                                            pengguna
                                        </th>
                                        <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 ">Email
                                        </th>
                                        <th class="font-semibold text-left py-2 px-4 border-r border-gray-300">Tanggal
                                            Dibuat
                                        </th>
                                        @auth
                                            @if (Auth::user()->role_id === 3)
                                                <th class="font-semibold text-left py-2 px-4 border-r border-gray-300">Tanggal
                                                    Aksi
                                                </th>
                                            @endif
                                        @endauth
                                    </thead>
                                    <tbody>
                                        @foreach ($managers as $index => $manager)
                                            <tr class="border border-gray-100 even:bg-gray-50">
                                                <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                                    <p>{{ $index + $managers->firstItem() }}</p>
                                                </td>
                                                <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                                    <p>{{ $manager->username }}</p>
                                                </td>
                                                <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                                    <p>{{ $manager->email }}</p>
                                                </td>
                                                <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                                    <p>{{ $manager->created_at->format('d-m-Y') }}</p>
                                                </td>
                                                @auth
                                                    @if (Auth::user()->role_id === 3)
                                                        <td class="px-4 py-3 text-left border-r border-gray-200">
                                                            {{-- delete  --}}
                                                            <x-modal title="Hapus Data Pengelola">
                                                                <x-slot name="buttonSlot">
                                                                    <button>
                                                                        <span class="material-symbols-outlined text-red-600">
                                                                            delete
                                                                        </span>
                                                                    </button>
                                                                </x-slot>

                                                                <x-slot name="contentSlot">
                                                                    <div class="w-[400px]">
                                                                        <p class="text-sm font-medium">Apakah anda yakin akan
                                                                            menghapus
                                                                            data pengelola <span
                                                                                class="font-bold">{{ $manager->username }}</span>?
                                                                            Data
                                                                            yang dihapus akan hilang dari list</p>

                                                                        <form
                                                                            action="{{ route('pengguna.destroy', $manager->id) }}"
                                                                            method="POST"
                                                                            class="mt-3 w-full flex items-center justify-end"
                                                                            id="deleteManagerForm">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="bg-red-600 text-white !px-3 !py-1 rounded-md">
                                                                                <p class="text-sm truncate">Hapus</p>
                                                                        </form>
                                                                        </button>
                                                                    </div>
                                                                </x-slot>
                                                            </x-modal>
                                                        </td>
                                                    @endif
                                                @endauth
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-8">
                                {{ $managers->appends(request()->except('page'))->links('vendor.pagination.default') }}
                            </div>
                        @endif
                    </div>

                    @auth
                        @if (Auth::user()->role_id === 3)
                            <div x-show="tab === 'pengurus'">
                                <form method="GET" action="{{ route('pengguna') }}"
                                    class="w-full flex items-center gap-5 mt-3 flex-1" id="filterSupervisorForm">

                                    <input type="hidden" name="tab" value="pengurus" />

                                    {{-- Search input --}}
                                    <div class="flex items-center w-1/4 border border-black/30 rounded-md">
                                        <input type="text"
                                            class="border-none bg-white flex-1 py-1.5 px-2 rounded-md focus:outline-none placeholder:text-black/50"
                                            placeholder="Cari nama pengguna" name="supervisors_search"
                                            value="{{ old('supervisors_search', $supervisorSearch) }}" />
                                        <div class="flex items-center justify-center pr-3">
                                            <span class="material-symbols-outlined" style="font-size: 20px">
                                                search
                                            </span>
                                        </div>
                                    </div>

                                    @if ($supervisorSearch)
                                        <button type="button" onclick="resetSupervisorFilter()"
                                            class="px-8 py-1.5 bg-primary text-black font-semibold rounded-md">Reset</button>
                                    @endif
                                </form>

                                @if ($supervisors->isEmpty())
                                    <div class="w-full h-full">
                                        <x-user-error-state>
                                            <div class="mt-4 md:mt-7">
                                                <p class="font-semibold text-3xl md:text-4xl text-center md:text-left">Data
                                                    Pengurus
                                                    <br> tidak
                                                    ditemukan
                                                </p>
                                            </div>
                                        </x-user-error-state>
                                    </div>
                                @else
                                    <div class="flex-1 mt-4 overflow-y-auto custom-scrollbar pr-2">
                                        <table class="w-full rounded-md">
                                            <thead class="bg-gray-200 rounded-md w-full sticky top-0 z-10">
                                                <th
                                                    class="font-semibold border-r border-gray-300 text-left py-2 px-4 rounded-tl-md">
                                                    No
                                                </th>
                                                <th class="font-semibold border-r border-gray-300 text-left py-2 px-4">Nama
                                                    pengguna
                                                </th>
                                                <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 ">Email
                                                </th>
                                                <th class="font-semibold text-left py-2 px-4 border-r border-gray-300">Tanggal
                                                    Dibuat
                                                </th>
                                                <th class="font-semibold text-left py-2 px-4 border-r border-gray-300">Tanggal
                                                    Aksi
                                                </th>
                                            </thead>
                                            <tbody>
                                                @foreach ($supervisors as $index => $supervisor)
                                                    <tr class="border border-gray-100 even:bg-gray-50">
                                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                                            <p>{{ $index + $supervisors->firstItem() }}</p>
                                                        </td>
                                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                                            <p>{{ $supervisor->username }}</p>
                                                        </td>
                                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                                            <p>{{ $supervisor->email }}</p>
                                                        </td>
                                                        <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                                            <p>{{ $supervisor->created_at->format('d-m-Y') }}</p>
                                                        </td>
                                                        <td class="px-4 py-3 text-left border-r border-gray-200">
                                                            {{-- delete  --}}
                                                            <x-modal title="Hapus Data Pengurus">
                                                                <x-slot name="buttonSlot">
                                                                    <button>
                                                                        <span class="material-symbols-outlined text-red-600">
                                                                            delete
                                                                        </span>
                                                                    </button>
                                                                </x-slot>

                                                                <x-slot name="contentSlot">
                                                                    <div class="w-[400px]">
                                                                        <p class="text-sm font-medium">Apakah anda yakin akan
                                                                            menghapus
                                                                            data <picture></picture>engurus <span
                                                                                class="font-bold">{{ $supervisor->username }}</span>?
                                                                            Data
                                                                            yang dihapus akan hilang dari list</p>

                                                                        <form
                                                                            action="{{ route('pengguna.destroy', $supervisor->id) }}"
                                                                            method="POST"
                                                                            class="mt-3 w-full flex items-center justify-end"
                                                                            id="deleteSupervisorForm">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="bg-red-600 text-white !px-3 !py-1 rounded-md">
                                                                                <p class="text-sm truncate">Hapus</p>
                                                                        </form>
                                                                        </button>
                                                                    </div>
                                                                </x-slot>
                                                            </x-modal>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-8">
                                        {{ $supervisors->appends(request()->except('page'))->links('vendor.pagination.default') }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function resetStudentFilter() {
        const formStudent = document.querySelector('#filterStudentsForm');
        if (!formStudent) {
            console.error('Form with ID #filterStudentsForm not found');
            return;
        }

        const searchInput = formStudent.querySelector('input[name="students_search"]');
        const memberSelect = formStudent.querySelector('select[name="member_filter"]');

        if (searchInput) searchInput.value = '';
        if (memberSelect) memberSelect.value = '';
        formStudent.submit();
    }

    function resetManagerFilter() {
        const formManager = document.querySelector('#filterManagerForm');
        if (!formManager) {
            console.error('Form with ID #filterStudentsForm not found');
            return;
        }

        const searchInput = formManager.querySelector('input[name="managers_search"]');
        if (searchInput) searchInput.value = '';

        formManager.submit();
    }

    function resetSupervisorFilter() {
        const supervisorForm = document.querySelector('#filterSupervisorForm');
        if (!supervisorForm) {
            console.error('Form with ID #filterStudentsForm not found');
            return;
        }

        const searchInput = supervisorForm.querySelector('input[name="supervisors_search"]');
        if (searchInput) searchInput.value = '';

        supervisorForm.submit();
    }
</script>
