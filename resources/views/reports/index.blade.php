@extends('layout.dashboard')

@section('section')
    <div class="p-10 flex flex-col h-full">
        <x-badge class="px-4 rounded-md">
            <p class="font-medium">Laporan</p>
        </x-badge>

        <div class="flex items-center flex-wrap w-full">
            <form method="GET" action="" class="w-full flex flex-wrap items-center gap-5 mt-6 flex-1"
                id="filterReportForm">
                <div class="flex items-center w-1/4 border border-black/30 rounded-md">
                    <input type="text"
                        class="border-none bg-white flex-1 py-1.5 px-2 rounded-md focus:outline-none placeholder:text-black/50"
                        placeholder="Cari judul" name="report_search" value="{{ old('report_search', $reportSearch) }}" />
                    <div class="flex items-center justify-center pr-3">
                        <span class="material-symbols-outlined" style="font-size: 20px">
                            search
                        </span>
                    </div>
                </div>

                <select name="report_type" id="reporterSelect"
                    class="rounded-md border border-black/30 focus:outline-none p-2" onchange="this.form.submit()">
                    <option value="">Pilih Jenis Laporan</option>
                    <option value="loans" {{ $reportType == 'loans' ? 'selected' : '' }}>Peminjaman</option>
                    <option value="visits" {{ $reportType == 'visits' ? 'selected' : '' }}>Kunjungan</option>
                    <option value="fines" {{ $reportType == 'fines' ? 'selected' : '' }}>Denda</option>
                </select>

                @if ($reportSearch || $reportType)
                    <button type="button" onclick="resetReportFilters()"
                        class="px-8 py-1.5 bg-primary text-black font-semibold rounded-md">Reset</button>
                @endif
            </form>
        </div>

        @if ($reports->isEmpty())
            <div class="w-full h-full">
                <x-book-error-state>
                    <div class="mt-4 md:mt-7">
                        <p class="font-semibold text-3xl md:text-4xl text-center md:text-left">Laporan <br> tidak
                            ditemukan
                        </p>
                    </div>
                </x-book-error-state>
            </div>
        @endif

        <div class="flex-1 w-full mt-5 overflow-y-auto custom-scrollbar pr-2">
            <table class="w-full rounded-md">
                <thead class="bg-gray-200 rounded-md w-full sticky top-0 z-10">
                    <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 rounded-tl-md">No
                    </th>
                    <th class="font-semibold border-r border-gray-300 text-left py-2 px-4">Judul laporan</th>
                    <th class="font-semibold text-left py-2 px-4 border-r border-gray-300">Pelapor</th>
                    <th class="font-semibold text-left py-2 px-4 border-r border-gray-300">Jenis laporan</th>
                    <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 ">Waktu laporan
                    </th>
                    <th class="font-semibold text-left py-2 px-4 rounded-tr-md">Aksi</th>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr class="border border-gray-100 even:bg-gray-50">
                            <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                <p>{{ $loop->iteration }}</p>
                            </td>
                            <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                <p>{{ $report->title }}</p>
                            </td>
                            <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                <p>{{ $report->reporter->username }}</p>
                            </td>
                            <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                <p>
                                    @if ($report->report_type === 'loans')
                                        Peminjaman
                                    @elseif ($report->report_type === 'visits')
                                        Kunjungan
                                    @elseif ($report->report_type === 'fines')
                                        Denda
                                    @elseif ($report->report_type === 'members')
                                        Member
                                    @endif
                                </p>
                            </td>
                            <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                <p>{{ $report->created_at }}</p>
                            </td>
                            <td class="px-4 py-3 text-left border-r border-gray-200">
                                @auth
                                    @if (Auth::user()->role_id === 3)
                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('laporan.detail', $report->id) }}" method="GET">
                                                <button type="submit">
                                                    <span class="material-symbols-outlined">
                                                        visibility
                                                    </span>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                                @auth
                                    @if (Auth::user()->role_id === 2)
                                        <div class="flex items-center gap-2">

                                            {{-- edit  --}}
                                            <x-modal title="Edit Laporan">
                                                <x-slot name="buttonSlot">
                                                    <button>
                                                        <span class="material-symbols-outlined">
                                                            edit
                                                        </span>
                                                    </button>
                                                </x-slot>
                                                <x-slot name="contentSlot">
                                                    <div class="w-full h-fit">
                                                        <form action="{{ route('laporan.update', $report->id) }}" method="POST"
                                                            class="h-full flex flex-col gap-y-3">
                                                            @csrf
                                                            @method('PUT')

                                                            <input type="text"
                                                                class="rounded-md border border-black/30 px-1 py-2" required
                                                                name="title" placeholder="Judul laporan"
                                                                value="{{ old('title', $report->title ?? '') }}" />

                                                            <div class="flex items-center justify-end">
                                                                <button type="submit"
                                                                    class="px-2 py-1 bg-primary rounded-md">Edit
                                                                    Denda</button>
                                                            </div>
                                                        </form>
                                                        </button>
                                                    </div>
                                                </x-slot>
                                            </x-modal>

                                            {{-- delete  --}}
                                            <x-modal title="Hapus Data Laporan">
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
                                                            data laporan dengan judul <span
                                                                class="font-bold">{{ $report->title }}</span>?
                                                            Data
                                                            yang dihapus akan hilang dari list</p>

                                                        <form action="{{ route('laporan.destroy', $report->id) }}"
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
                                    @endif
                                @endauth


                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="mt-8">
            {{ $reports->appends(request()->except('page'))->links('vendor.pagination.default') }} </div>

    </div>
@endsection


<script>
    function resetReportFilters() {
        const form = document.querySelector('#filterReportForm');
        form.querySelector('input[name="report_search"]').value = '';
        form.querySelector('select[name="report_type"]').value = '';

        form.submit();
    }
</script>
