@extends('layout.dashboard')

@section('section')
    <div class="p-10 flex flex-col h-full">
        <x-badge class="px-4 rounded-md">
            <p class="font-medium">Kunjungan</p>
        </x-badge>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-5 mt-6">
                <form method="GET" action="{{ route('kunjungan') }}" id="filterVisitForm" class="inline m-0 p-0">

                    <input type="hidden" name="visit_date" value="{{ old('visit_date', $visitDate) }}">

                    {{-- Search input --}}
                    <div class="flex items-center w-full border border-black/30 rounded-md">
                        <input type="text"
                            class="border-none bg-white flex-1 py-1.5 px-2 rounded-md focus:outline-none placeholder:text-black/50"
                            placeholder="Cari nama pengunjung" name="visit_search"
                            value="{{ old('visit_search', $visitSearch) }}" />
                        <div class="flex items-center justify-center pr-3">
                            <span class="material-symbols-outlined" style="font-size: 20px">
                                search
                            </span>
                        </div>
                    </div>
                </form>
                <div x-data="{ currentDate: '', flatpickrInstance: null }" x-init="flatpickrInstance = flatpickr($refs.dateInput, {
                    altInput: true,
                    altFormat: 'F j, Y',
                    dateFormat: 'Y-m-d',
                    onChange: function(selectedDates, dateStr, instance) {
                        currentDate = dateStr;
                        filterVisitDate(dateStr)
                    }
                })"
                    class="flex items-center border border-black/30 rounded-md">
                    <label for="loanDatePicker" class="px-2">
                        <span class="material-symbols-outlined text-[#0B0B0B]/50">
                            calendar_month
                        </span>
                    </label>

                    <input x-ref="dateInput" type="text" placeholder="YYYY-MM-DD"
                        value="{{ old('visit_date', $visitDate) }}"
                        class="w-full border-none rounded-md focus:outline-none py-1.5 flex-1 text-black/50" />
                </div>

                @if ($visitSearch || $visitDate)
                    <button type="button" onclick="resetVisitFilters()"
                        class="px-8 py-1.5 bg-primary text-black font-semibold rounded-md">Reset</button>
                @endif
            </div>
            @auth
                @if (Auth::user()->role_id === 2)
                    <x-dropdown class="!border-none !shadow-none !p-0" position="left">
                        <x-slot name="buttonSlot">
                            <div class="px-5 py-1.5 bg-accent text-white font-medium rounded-md text-sm">Aksi</div>
                        </x-slot>
                        <x-slot name="contentSlot">
                            <div class="flex gap-y-2 flex-col">

                                {{-- Create Report  --}}
                                <x-modal title="Buat Laporan" buttonContainerClass="!w-full">
                                    <x-slot name="buttonSlot">
                                        <button type="button"
                                            class="px-5 py-1.5 bg-transparent border border-black/30 hover:bg-gray-100 duration-200 text-black font-medium rounded-md text-xs w-full">Buat
                                            Laporan</button>
                                    </x-slot>

                                    <x-slot name="contentSlot">
                                        <form action="{{ route('laporan.store') }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="report_type" value="visits">
                                            <input type="hidden" name="data" value="{{ json_encode($visits) }}">
                                            <input type="text" name="title" id="reportTitleInput"
                                                class="rounded-md w-full border border-black/30 p-2"
                                                placeholder="Judul Laporan">
                                            <div class="mt-3 flex w-full items-center justify-end">
                                                <button type="submit" class="bg-primary px-3 py-2 rounded-md">Buat
                                                    Laporan</button>
                                            </div>
                                        </form>
                                    </x-slot>
                                </x-modal>

                                {{-- Create Visits  --}}
                                <x-modal title="Tambah Data Peminjam" buttonContainerClass="!w-full">
                                    <x-slot name="buttonSlot">
                                        <button type="button"
                                            class="px-5 py-1.5 bg-transparent border border-black/30 hover:bg-gray-100 duration-200 text-black font-medium rounded-md text-xs w-full">Tambah
                                            Kunjungan</button>
                                    </x-slot>

                                    <x-slot name="contentSlot">
                                        <form action="{{ route('kunjungan.store') }}" method="POST"
                                            class="w-full h-full md:h-[250px] flex flex-col gap-y-3">
                                            @csrf
                                            <input type="text" placeholder="Nama pengunjung" name="visiters_name" required
                                                class="px-1 py-2 rounded-md border border-black/30 w-full" />

                                            <input type="date" name="visit_date" required
                                                class="px-1 py-2 rounded-md border border-black/30 w-full" />

                                            <textarea name="visit_desc" placeholder="Deskripsi atau Catatan"
                                                class="px-1 py-2 rounded-md border border-black/30 w-full flex-1"></textarea>


                                            <div class="w-full flex items-center justify-end">
                                                <button type="submit" class="px-2 py-1 bg-primary rounded-md">Tambah</button>
                                            </div>
                                        </form>
                                    </x-slot>
                                </x-modal>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @endif
            @endauth

        </div>

        @if ($visits->isEmpty())
            <div class="w-full h-full">
                <x-visit-error-state>
                    <div class="mt-4 md:mt-7">
                        <p class="font-semibold text-3xl md:text-4xl text-center md:text-left">Kunjungan <br> tidak
                            ditemukan
                        </p>
                    </div>
                </x-visit-error-state>
            </div>
        @else
            <div class="flex-1 w-full mt-5 overflow-y-auto custom-scrollbar pr-2">
                <table class="w-full rounded-md">
                    <thead class="bg-gray-200 rounded-md w-full sticky top-0 z-10">
                        <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 rounded-tl-md">No
                        </th>
                        <th class="font-semibold border-r border-gray-300 text-left py-2 px-4">Nama pengunjung</th>
                        <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 ">Tanggal kedatangan
                        </th>
                        <th class="font-semibold text-left py-2 px-4 border-r border-gray-300">Deskripsi</th>
                        <th class="font-semibold text-left py-2 px-4 rounded-tr-md">Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($visits as $visit)
                            <tr class="border border-gray-100 even:bg-gray-50">
                                <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                    <p>{{ $loop->iteration }}</p>
                                </td>
                                <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                    <p>{{ $visit->name }}</p>
                                </td>
                                <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                    <p>{{ $visit->date }}</p>
                                </td>
                                <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                    <p>{{ $visit->description ? $visit->description : '-' }}</p>
                                </td>
                                <td class="px-4 py-3 text-left border-r border-gray-200">
                                    <div class="flex items-center gap-2">
                                        {{-- edit  --}}
                                        <x-modal title="Edit Data Peminjam">
                                            <x-slot name="buttonSlot">
                                                <button>
                                                    <span class="material-symbols-outlined">
                                                        edit
                                                    </span>
                                                </button>
                                            </x-slot>

                                            <x-slot name="contentSlot">
                                                <form action="{{ route('kunjungan.update') }}" method="POST"
                                                    class="w-full h-full md:h-[250px] flex flex-col gap-y-3">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="visit_id" value="{{ $visit->id }}">
                                                    <input type="text" placeholder="Nama pengunjung"
                                                        name="visiters_name" required
                                                        class="px-1 py-2 rounded-md border border-black/30 w-full"
                                                        value="{{ $visit->name }}" />

                                                    <input type="date" name="visit_date" required
                                                        value="{{ $visit->date }}"
                                                        class="px-1 py-2 rounded-md border border-black/30 w-full" />

                                                    <textarea name="visit_desc" placeholder="Deskripsi atau Catatan"
                                                        class="rounded-md border px-1 py-2 border-black/30 w-full flex-1 text-left">{{ old('visit_desc', $visit->description) }}</textarea>


                                                    <div class="w-full flex items-center justify-end">
                                                        <button type="submit"
                                                            class="px-2 py-1 bg-primary rounded-md">Tambah</button>
                                                    </div>
                                                </form>
                                            </x-slot>

                                        </x-modal>

                                        {{-- delete  --}}
                                        <x-modal title="Hapus Data Peminjam">
                                            <x-slot name="buttonSlot">
                                                <button>
                                                    <span class="material-symbols-outlined text-red-600">
                                                        delete
                                                    </span>
                                                </button>
                                            </x-slot>

                                            <x-slot name="contentSlot">
                                                <div class="w-[400px]">
                                                    <p class="text-sm font-medium">Apakah anda yakin akan menghapus
                                                        data kunjungan <span class="font-bold">{{ $visit->name }}</span>?
                                                        Data
                                                        yang dihapus akan hilang dari list</p>

                                                    <form action="{{ route('kunjungan.destroy', $visit->id) }}"
                                                        method="POST" class="mt-3 w-full flex items-center justify-end"
                                                        id="deleteVisitForm">
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
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $visits->appends(request()->except('page'))->links('vendor.pagination.default') }} </div>
        @endif

    </div>
@endsection

<script>
    function resetVisitFilters() {
        const form = document.querySelector('#filterVisitForm');
        form.querySelector('input[name="visit_search"]').value = '';

        let visitDateInput = form.querySelector('input[name="visit_date"]');
        if (visitDateInput) {
            visitDateInput.value = '';
        }

        form.submit();
    }

    function filterVisitDate(date) {
        const form = document.querySelector('#filterVisitForm');
        form.querySelector('input[name="visit_date"]').value = date;

        form.submit();
    }
</script>
