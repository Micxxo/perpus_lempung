@extends('layout.dashboard')

@section('section')
    <div class="p-10 flex flex-col h-full">
        <x-badge class="px-4 rounded-md">
            <p class="font-medium">Denda</p>
        </x-badge>

        <div class="flex items-center justify-between">
            <form method="GET" action="{{ route('denda') }}" class="w-full flex items-center gap-5 mt-6 flex-1"
                id="filterDendaForm">
                {{-- Search input --}}
                <div class="flex items-center w-1/4 border border-black/30 rounded-md">
                    <input type="text"
                        class="border-none bg-white flex-1 py-1.5 px-2 rounded-md focus:outline-none placeholder:text-black/50"
                        placeholder="Cari nama peminjam" name="fine_search" value="{{ old('fine_search', $fineSearch) }}" />
                    <div class="flex items-center justify-center pr-3">
                        <span class="material-symbols-outlined" style="font-size: 20px">
                            search
                        </span>
                    </div>
                </div>

                <select name="fine_status" id="statusSelect"
                    class="rounded-md border border-black/30 focus:outline-none p-2" onchange="this.form.submit()">
                    <option value="">Pilih Status Denda</option>
                    <option value="success" {{ $fineStatus == 'success' ? 'selected' : '' }}>Selesai</option>
                    <option value="proccess" {{ $fineStatus == 'proccess' ? 'selected' : '' }}>Diproses
                    </option>
                </select>

                <select name="fine_book_status" id="statusBookSelect"
                    class="rounded-md border border-black/30 focus:outline-none p-2" onchange="this.form.submit()">
                    <option value="">Pilih Status Buku</option>
                    <option value="pay_for_book" {{ $fineBookStatus == 'pay_for_book' ? 'selected' : '' }}>Membayar seharga
                        buku
                    </option>
                    <option value="change_book" {{ $fineBookStatus == 'change_book' ? 'selected' : '' }}>Mengganti buku
                    </option>
                    <option value="paying_fine" {{ $fineBookStatus == 'paying_fine' ? 'selected' : '' }}>Membayar denda
                    </option>
                </select>

                @if ($fineSearch || $fineStatus || $fineBookStatus)
                    <button type="button" onclick="resetFineFilter()"
                        class="px-8 py-1.5 bg-primary text-black font-semibold rounded-md">Reset</button>
                @endif
            </form>

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
                                            <input type="hidden" name="report_type" value="fines">
                                            <input type="hidden" name="data" value="{{ json_encode($fines) }}">
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

                                {{-- Add new Fine  --}}
                                <x-modal title="Buat Denda" buttonContainerClass="!w-full">
                                    <x-slot name="buttonSlot">
                                        <button type="button"
                                            class="px-5 py-1.5 bg-transparent border border-black/30 hover:bg-gray-100 duration-200 text-black font-medium rounded-md text-xs w-full">Buat
                                            Denda</button>
                                    </x-slot>
                                    <x-slot name="contentSlot">
                                        <div class="w-[400px] h-[350px]">
                                            <form action="{{ route('denda.store') }}" method="POST"
                                                class="h-full flex flex-col gap-y-3">
                                                @csrf

                                                {{-- loan  --}}
                                                <select name="loan_id" id="loanData"
                                                    class="rounded-md border border-black/30 px-1 py-2" required>
                                                    <option value="">Pilih data peminjam</option>
                                                    @foreach ($loans as $loan)
                                                        <option value="{{ $loan->id }}">
                                                            <p>{{ $loan->member->user->username }} - @if ($loan->status === 'returned')
                                                                    Dikembalikan
                                                                @elseif ($loan->status === 'borrowed')
                                                                    Dipinjam
                                                                @elseif ($loan->status === 'late')
                                                                    Telat
                                                                @elseif ($loan->status === 'deadline')
                                                                    Deadline
                                                                @else
                                                                    Status Tidak Diketahui
                                                                @endif
                                                            </p>
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <select name="status" id="fineBookStatus"
                                                    class="rounded-md border border-black/30 px-1 py-2">
                                                    <option value="">Pilih status buku</option>
                                                    <option value="pay_for_book">Membayar seharga buku
                                                    </option>
                                                    <option value="change_book">Mengganti buku</option>
                                                    <option value="paying_fine">Membayar Denda</option>
                                                </select>

                                                <select name="is_done" id="fineStatus"
                                                    class="rounded-md border border-black/30 px-1 py-2">
                                                    <option value="">Pilih status denda</option>
                                                    <option value="1">Selesai</option>
                                                    <option value="0">Diproses</option>
                                                </select>

                                                <div class="flex flex-col gap-y-1">
                                                    <label for="inputCreateFineDate"
                                                        class="text-sm text-black/50">Tanggal</label>
                                                    <input type="date" class="rounded-md border border-black/30 px-1 py-2"
                                                        name="date" id="inputCreateFineDate" />
                                                </div>

                                                <textarea name="description" placeholder="Deskripsi" id="createFineDescription"
                                                    class="rounded-md border border-black/30 px-1 py-2 flex-1"></textarea>

                                                <div class="flex items-center justify-end">
                                                    <button type="submit" class="px-2 py-1 bg-primary rounded-md">Buat
                                                        Denda</button>
                                                </div>
                                            </form>
                                            </button>
                                        </div>
                                    </x-slot>
                                </x-modal>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @endif
            @endauth

        </div>


        @if ($fines->isEmpty())
            <div class="w-full h-full">
                <x-fine-error-state>
                    <div class="mt-4 md:mt-7">
                        <p class="font-semibold text-3xl md:text-4xl text-center md:text-left">Denda <br> tidak
                            ditemukan
                        </p>
                    </div>
                </x-fine-error-state>
            </div>
        @endif

        <div class="flex-1 w-full mt-5 overflow-y-auto custom-scrollbar pr-2">
            <table class="w-full rounded-md">
                <thead class="bg-gray-200 rounded-md w-full sticky top-0 z-10">
                    <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 rounded-tl-md">No
                    </th>
                    <th class="font-semibold border-r border-gray-300 text-left py-2 px-4">Nama buku</th>
                    <th class="font-semibold border-r border-gray-300 text-left py-2 px-4 ">Peminjam
                    </th>
                    <th class="font-semibold text-left py-2 px-4 border-r border-gray-300">Status buku</th>
                    <th class="font-semibold text-left py-2 px-4 border-r border-gray-300">Status denda</th>
                    <th class="font-semibold text-left py-2 px-4 border-r border-gray-300">Deskripsi</th>
                    <th class="font-semibold text-left py-2 px-4 rounded-tr-md">Aksi</th>
                </thead>
                <tbody>
                    @foreach ($fines as $fine)
                        <tr class="border border-gray-100 even:bg-gray-50">
                            <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                <p>{{ $loop->iteration }}</p>
                            </td>
                            <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                <p>{{ $fine->loan->book->name }}</p>
                            </td>
                            <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                <p>{{ $fine->loan->member->user->username }}</p>
                            </td>
                            <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                <p>
                                    @if ($fine->status === 'paying_fine')
                                        Membayar denda
                                    @elseif ($fine->status === 'change_book')
                                        Mengganti buku
                                    @elseif ($fine->status === 'pay_for_book')
                                        Membayar seharga buku
                                    @else
                                        Status tidak dikenal
                                    @endif
                                </p>
                            </td>
                            <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                <p>
                                    @if ($fine->is_done)
                                        Selesai
                                    @else
                                        Dalam Proses
                                    @endif
                                </p>
                            </td>
                            <td class="px-4 py-3 text-left border-r border-gray-200 ">
                                <p>{{ $fine->description ? $fine->description : '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-left border-r border-gray-200 flex items-center gap-2">
                                {{-- edit  --}}
                                <x-modal title="Edit Denda">
                                    <x-slot name="buttonSlot">
                                        <button>
                                            <span class="material-symbols-outlined">
                                                edit
                                            </span>
                                        </button>
                                    </x-slot>
                                    <x-slot name="contentSlot">
                                        <div class="w-[400px] h-[350px]">
                                            <form action="{{ route('denda.update', $fine->id) }}" method="POST"
                                                class="h-full flex flex-col gap-y-3">
                                                @csrf
                                                @method('PUT')

                                                <select name="status" id="fineBookStatus"
                                                    class="rounded-md border border-black/30 px-1 py-2">
                                                    <option value="">Pilih status buku</option>
                                                    <option value="pay_for_book"
                                                        {{ old('status', $fine->status) === 'pay_for_book' ? 'selected' : '' }}>
                                                        Membayar seharga buku
                                                    </option>
                                                    <option value="change_book"
                                                        {{ old('status', $fine->status) === 'change_book' ? 'selected' : '' }}>
                                                        Mengganti buku
                                                    </option>
                                                    <option value="paying_fine"
                                                        {{ old('status', $fine->status) === 'paying_fine' ? 'selected' : '' }}>
                                                        Membayar Denda
                                                    </option>
                                                </select>

                                                <select name="is_done" id="fineStatus"
                                                    class="rounded-md border border-black/30 px-1 py-2">
                                                    <option value="">Pilih status denda</option>
                                                    <option value="1"
                                                        {{ old('is_done', $fine->is_done) == 1 ? 'selected' : '' }}>
                                                        Selesai
                                                    </option>
                                                    <option value="0"
                                                        {{ old('is_done', $fine->is_done) == 0 ? 'selected' : '' }}>
                                                        Belum selesai
                                                    </option>
                                                </select>

                                                <div class="flex flex-col gap-y-1">
                                                    <label for="inputCreateFineDate"
                                                        class="text-sm text-black/50">Tanggal</label>
                                                    <input type="date"
                                                        class="rounded-md border border-black/30 px-1 py-2" name="date"
                                                        id="inputCreateFineDate"
                                                        value="{{ old('date', $fine->date ?? '') }}" />
                                                </div>

                                                <textarea name="description" placeholder="Deskripsi" id="createFineDescription"
                                                    class="rounded-md border border-black/30 px-1 py-2 flex-1">{{ old('description', $fine->description ?? '') }}</textarea>

                                                <div class="flex items-center justify-end">
                                                    <button type="submit" class="px-2 py-1 bg-primary rounded-md">Edit
                                                        Denda</button>
                                                </div>
                                            </form>
                                            </button>
                                        </div>
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
                                                data denda atas nama <span
                                                    class="font-bold">{{ $fine->loan->member->user->username }}</span>?
                                                Data
                                                yang dihapus akan hilang dari list</p>

                                            <form action="{{ route('denda.destroy', $fine->id) }}" method="POST"
                                                class="mt-3 w-full flex items-center justify-end" id="deleteVisitForm">
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

        @if ($fines && $fines->count() > 0)
            <div class="mt-8">
                {{ $fines->appends(request()->except('page'))->links('vendor.pagination.default') }}
            </div>
        @endif

    </div>
@endsection

<script>
    function resetFineFilter() {
        const form = document.querySelector('#filterDendaForm');
        form.querySelector('input[name="fine_search"]').value = '';
        form.querySelector('select[name="fine_status"]').value = '';
        form.querySelector('select[name="fine_book_status"]').value = '';
        form.submit();
    }
</script>
