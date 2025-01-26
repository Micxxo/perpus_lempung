@extends('layout.dashboard')

@section('section')
    @auth
        @if (auth()->user()->role_id === 1 && !auth()->user()->is_member)
            <x-member-only-notif>
                <div class="mt-4 md:mt-7">
                    <p class="font-semibold text-3xl md:text-4xl text-center md:text-left">Hanya Untuk <br> Member
                    </p>
                    <div class="mt-2">
                        <a href="/profil">
                            <button
                                class="bg-transparent border-primary rounded-md border px-10 py-2 hover:bg-primary duration-200">Daftar
                                Member</button>
                        </a>
                    </div>
                </div>
            </x-member-only-notif>
        @else
            <div class="p-10 flex flex-col h-full">
                <x-badge class="px-4 rounded-md">
                    <p class="font-medium">Peminjaman</p>
                </x-badge>

                <div class="flex flex-wrap items-center justify-between">
                    <div class="flex items-center gap-3 mt-6">
                        <form method="GET" action="{{ route('peminjaman') }}"
                            class="w-full flex items-center gap-5 m-0 p-0 flex-1" id="filterLoanForm">

                            <input type="hidden" name="loan_created_at" value="{{ old('loan_created_at', $loanCreatedAt) }}">

                            {{-- Input for save status value --}}
                            <input type="hidden" name="loanStatus" id="statusLoanInput"
                                value="{{ old('loanStatus', $loanStatus) }}" />

                            {{-- Search input for book title --}}
                            <div class="flex items-center border border-black/30 rounded-md">
                                <input type="text"
                                    class="border-none bg-white flex-1 py-1.5 px-2 rounded-md focus:outline-none placeholder:text-black/50"
                                    placeholder="Cari nama buku" name="book_title_search"
                                    value="{{ old('book_title_search', $bookTitleSearch) }}" />
                                <div class="flex items-center justify-center pr-3">
                                    <span class="material-symbols-outlined" style="font-size: 20px">
                                        search
                                    </span>
                                </div>
                            </div>
                            <x-dropdown position="left" class="!px-1 !py-0 !border-black/30 !rounded-[4px]" panelClass="mt-3"
                                containerClass="">
                                <x-slot name="buttonSlot">
                                    <div class="p-1 flex items-center gap-2">
                                        @if ($loanStatus === 'borrowed')
                                            <x-loan-status variant="borrowed" />
                                        @elseif ($loanStatus === 'returned')
                                            <x-loan-status variant="returned" />
                                        @elseif ($loanStatus === 'deadline')
                                            <x-loan-status variant="deadline" />
                                        @elseif ($loanStatus === 'late')
                                            <x-loan-status variant="late" />
                                        @elseif ($loanStatus === 'fine')
                                            <x-loan-status variant="fine" />
                                        @else
                                            <x-loan-status variant="all" />
                                        @endif

                                        <span class="material-symbols-outlined text-black/50" style="font-size: 28px">
                                            keyboard_arrow_down
                                        </span>
                                    </div>
                                </x-slot>


                                <x-slot name="contentSlot">
                                    <div class="space-y-1">
                                        <div class="p-2 rounded-sm flex items-center gap-2 cursor-pointer {{ $loanStatus == '' ? 'bg-gray-50' : 'hover:bg-gray-50 ' }}"
                                            onclick="setLoanStatus('')">
                                            <x-loan-status variant="all" />
                                        </div>
                                        <div class="p-2 rounded-sm flex items-center gap-2 cursor-pointer {{ $loanStatus == 'borrowed' ? 'bg-gray-50' : 'hover:bg-gray-50 ' }}"
                                            onclick="setLoanStatus('borrowed')">
                                            <x-loan-status variant="borrowed" />
                                        </div>
                                        <div class="p-2 rounded-sm flex items-center gap-2 cursor-pointer {{ $loanStatus == 'late' ? 'bg-gray-50' : 'hover:bg-gray-50 ' }}"
                                            onclick="setLoanStatus('late')">
                                            <x-loan-status variant="late" />
                                        </div>
                                        <div class="p-2 rounded-sm flex items-center gap-2 cursor-pointer {{ $loanStatus == 'deadline' ? 'bg-gray-50' : 'hover:bg-gray-50 ' }}"
                                            onclick="setLoanStatus('deadline')">
                                            <x-loan-status variant="deadline" />
                                        </div>
                                        <div class="p-2 rounded-sm flex items-center gap-2 cursor-pointer {{ $loanStatus == 'returned' ? 'bg-gray-50' : 'hover:bg-gray-50 ' }}"
                                            onclick="setLoanStatus('returned')">
                                            <x-loan-status variant="returned" />
                                        </div>
                                        <div class="p-2 rounded-sm flex items-center gap-2 cursor-pointer {{ $loanStatus == 'fines' ? 'bg-gray-50' : 'hover:bg-gray-50 ' }}"
                                            onclick="setLoanStatus('fine')">
                                            <x-loan-status variant="fine" />
                                        </div>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </form>

                        <div x-data="{ currentDate: '', flatpickrInstance: null }" x-init="flatpickrInstance = flatpickr($refs.dateInput, {
                            altInput: true,
                            altFormat: 'F j, Y',
                            dateFormat: 'Y-m-d',
                            onChange: (selectedDates, dateStr, _) => {
                                currentDate = dateStr;
                                handleLoanDateChange(dateStr)
                            }
                        })"
                            class="flex items-center border border-black/30 rounded-md">
                            <label for="loanDatePicker" class="px-2">
                                <span class="material-symbols-outlined text-[#0B0B0B]/50">
                                    calendar_month
                                </span>
                            </label>

                            <input x-ref="dateInput" type="text" id="loanDatePicker" name="loanDatePicker"
                                placeholder="Semua Tanggal"
                                class="w-full border-none rounded-md focus:outline-none py-1.5 flex-1 text-black/50"
                                value="{{ old('loanDatePicker', $loanCreatedAt) }}" />
                        </div>
                        @if ($bookTitleSearch || $loanStatus || $loanCreatedAt)
                            <button type="button" onclick="resetLoanFilters()"
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
                                                    <input type="hidden" name="report_type" value="loans">
                                                    <input type="hidden" name="data" value="{{ json_encode($loans) }}">
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

                                        {{-- Add new loan  --}}
                                        <x-modal title="Tambah Data Peminjam" buttonContainerClass="!w-full">
                                            <x-slot name="buttonSlot">
                                                <button type="button"
                                                    class="px-5 py-1.5 bg-transparent border border-black/30 hover:bg-gray-100 duration-200 text-black font-medium rounded-md text-xs w-full">Tambah
                                                    Peminjaman</button>
                                            </x-slot>

                                            <x-slot name="contentSlot">
                                                @if ($books->isEmpty())
                                                    <div class="w-[500px] h-[400px] flex flex-col items-center justify-center">
                                                        <span class="material-symbols-outlined" style="font-size: 64px">
                                                            warning
                                                        </span>
                                                        <h1 class="font-semibold">Tidak ada buku yang tersedia</h1>
                                                    </div>
                                                @elseif ($members->isEmpty())
                                                    <div class="w-[500px] h-[400px] flex flex-col items-center justify-center">
                                                        <span class="material-symbols-outlined" style="font-size: 64px">
                                                            warning
                                                        </span>
                                                        <h1 class="font-semibold">Tidak ada member yang terdaftar</h1>
                                                    </div>
                                                @else
                                                    <form action="{{ route('peminjaman.store') }}" method="POST"
                                                        enctype="multipart/form-data" class="w-[500px] h-[400px] flex flex-col"
                                                        id="createBookForm">
                                                        @csrf
                                                        <div class="flex flex-col flex-1 w-full gap-y-3">
                                                            <input type="hidden" name="selected_loan_book"
                                                                id="selected_loan_book">

                                                            <select name="loan_book_name" id="loanBookName"
                                                                class="border py-3 px-2 rounded-md border-black/30" required>
                                                                <option value="">Pilih Buku</option>
                                                                @foreach ($books as $book)
                                                                    <option value="{{ $book->id }}">{{ $book->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            <select name="loan_member" id="loanMember"
                                                                class="border py-3 px-2 rounded-md border-black/30" required>
                                                                <option value="">Pilih Member</option>
                                                                @foreach ($members as $member)
                                                                    <option value="{{ $member->id }}">
                                                                        {{ $member->user->username }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            <div class="grid grid-cols-2 gap-5">
                                                                <div class="w-full flex flex-col gap-y-1">
                                                                    <label for="borrowingDate"
                                                                        class="text-sm text-black/80">Tanggal
                                                                        Dipinjam</label>
                                                                    <input type="date" id="borrowingDate"
                                                                        class="border py-3 px-2 rounded-md border-black/30"
                                                                        placeholder="Tanggal dipinjam" name="borrowing_date"
                                                                        oninput="validateLoanDates()">
                                                                </div>
                                                                <div class="w-full flex flex-col gap-y-1">
                                                                    <label for="returningDate"
                                                                        class="text-sm text-black/80">Tanggal
                                                                        Dikembalikan</label>
                                                                    <input type="date" id="returningDate"
                                                                        class="border py-3 px-2 rounded-md border-black/30"
                                                                        placeholder="Tanggal dikembalikan" name="returning_date"
                                                                        oninput="validateLoanDates()">
                                                                </div>
                                                            </div>

                                                            <textarea name="loan_description" id="loanDesc" placeholder="Deskripsi"
                                                                class="flex-1 border py-3 px-2 rounded-md border-black/30"></textarea>
                                                        </div>
                                                        <div class="w-full flex justify-end items-center mt-5">
                                                            <button type="submit"
                                                                class="bg-primary px-3 py-1 rounded-md">Simpan</button>
                                                        </div>
                                                    </form>
                                                @endif
                                            </x-slot>
                                        </x-modal>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        @endif
                    @endauth

                </div>

                @if ($loans->isEmpty())
                    <div class="w-full h-full">
                        <x-book-error-state>
                            <div class="mt-4 md:mt-7">
                                <p class="font-semibold text-3xl md:text-4xl text-center md:text-left">Peminjaman <br> tidak
                                    ditemukan
                                </p>
                            </div>
                        </x-book-error-state>
                    </div>
                @else
                    <div x-data="{ selectedLoan: null }" x-init="selectedLoan = @js($firstLoan)" class="mt-5 flex-1 flex w-full overflow-y-auto">
                        <div class="w-[40%] h-full flex flex-col ">
                            <div class="flex-1 space-y-5 overflow-y-auto custom-scrollbar pr-3">
                                @foreach ($loans as $loan)
                                    <div @click="selectedLoan = @js($loan)"
                                        class="py-2 px-3 rounded-2xl border border-black/30 cursor-pointer hover:bg-gray-50 active:bg-gray-100"
                                        :class="{ 'bg-gray-100': selectedLoan.id === @js($loan).id }"">
                                        <div>
                                            <p class="text-black/50 text-xs">Nama Buku</p>
                                            <div class="flex items-center gap-2 w-full">
                                                <h1 class="text-black text-sm truncate">{{ $loan->book->name }}</h1>
                                                <x-loan-status variant="{{ $loan->status }}" />
                                            </div>
                                        </div>
                                        <div class="mt-3 flex items-center gap-x-16 flex-wrap">
                                            <div>
                                                <p class="text-xs text-black/50">Dari</p>
                                                <h1 class="text-sm text-black">
                                                    {{ $loan->formatted_date }}</h1>
                                            </div>
                                            <div>
                                                <p class="text-xs text-black/50">Sampai</p>
                                                <h1 class="text-sm text-black">{{ $loan->formatted_return_date }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-8">
                                {{ $loans->appends(request()->except('page'))->links('vendor.pagination.default') }} </div>
                        </div>
                        <div class="flex-1 px-10">
                            <div class="grid grid-cols-1 md:grid-cols-2" x-show="selectedLoan" x-cloak>
                                <div class="flex flex-col gap-y-5">
                                    <h1 class="font-semibold">Detail Pinjaman</h1>
                                    <div>
                                        <p class="text-black/50 text-xs">Nama Buku</p>
                                        <h1 class="text-sm" x-text="selectedLoan.book.name"></h1>
                                    </div>

                                    <div>
                                        <p class="text-xs text-black/50">Dari</p>
                                        <h1 class="text-sm text-black" x-text="formatLoanDate(selectedLoan.created_at)">
                                        </h1>
                                    </div>
                                    <div>
                                        <p class="text-xs text-black/50">Sampai</p>
                                        <h1 class="text-sm text-black" x-text="formatLoanDate(selectedLoan.return_date)">
                                    </div>

                                    <div>
                                        <p class="text-xs text-black/50">Status</p>
                                        <div class="mt-2">
                                            <div x-cloak x-show="selectedLoan.status === 'returned'">
                                                <x-loan-status variant="returned" />
                                            </div>
                                            <div x-cloak x-show="selectedLoan.status === 'borrowed'">
                                                <x-loan-status variant="borrowed" />
                                            </div>
                                            <div x-cloak x-show="selectedLoan.status === 'late'">
                                                <x-loan-status variant="late" />
                                            </div>
                                            <div x-cloak x-show="selectedLoan.status === 'fine'">
                                                <x-loan-status variant="fine" />
                                            </div>
                                            <div x-cloak x-show="selectedLoan.status === 'deadline'">
                                                <x-loan-status variant="deadline" />
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <p class="text-xs text-black/50">Deskripsi</p>
                                        <h1 class="text-sm text-black"
                                            x-text="selectedLoan.description ? selectedLoan.description : '-'">
                                    </div>

                                    @auth
                                        @if (Auth::user()->role_id === 2)
                                            <div>
                                                <p class="text-xs text-black/50">Aksi</p>
                                                <div class="mt-2 flex items-center flex-wrap gap-2">

                                                    {{-- edit  --}}
                                                    <x-modal title="Update Data Peminjaman">
                                                        <x-slot name="buttonSlot">
                                                            <button type="button"
                                                                class="bg-green-600 text-white !px-3 !py-1 !rounded-xl">
                                                                <p class="text-xs truncate">Update</p>
                                                            </button>
                                                        </x-slot>

                                                        <x-slot name="contentSlot">
                                                            <form action="{{ route('peminjaman.update') }}" method="POST"
                                                                enctype="multipart/form-data"
                                                                class="w-[500px] h-[400px] flex flex-col" id="createBookForm">
                                                                @method('PUT')
                                                                @csrf
                                                                <input type="hidden" name="loan_id"
                                                                    x-bind:value="selectedLoan.id">

                                                                <div class="flex flex-col flex-1 w-full gap-y-3">
                                                                    <select name="loan_book_name" id="loanBookName"
                                                                        class="border py-3 px-2 rounded-md border-black/30"
                                                                        x-bind:value="selectedLoan.book_id" required>
                                                                        <option value="">Pilih Buku</option>
                                                                        @foreach ($books as $book)
                                                                            <option value="{{ $book->id }}">
                                                                                {{ $book->name }}</option>
                                                                        @endforeach
                                                                    </select>

                                                                    <select name="loan_member" id="loanMember"
                                                                        class="border py-3 px-2 rounded-md border-black/30"
                                                                        x-bind:value="selectedLoan.member_id" required>
                                                                        <option value="">Pilih Member</option>
                                                                        @foreach ($members as $member)
                                                                            <option value="{{ $member->id }}">
                                                                                {{ $member->user->username }}</option>
                                                                        @endforeach
                                                                    </select>

                                                                    <div class="grid grid-cols-2 gap-5">
                                                                        <div class="w-full flex flex-col gap-y-1">
                                                                            <label for="borrowingDate"
                                                                                class="text-sm text-black/80">Tanggal
                                                                                Dipinjam</label>
                                                                            <input type="date" id="borrowingDate"
                                                                                class="border py-3 px-2 rounded-md border-black/30"
                                                                                placeholder="Tanggal dipinjam"
                                                                                name="borrowing_date"
                                                                                x-bind:value="formatCreatedAtOnUpdate(selectedLoan
                                                                                    .created_at)"
                                                                                required>

                                                                        </div>
                                                                        <div class="w-full flex flex-col gap-y-1">
                                                                            <label for="returningDate"
                                                                                class="text-sm text-black/80">Tanggal
                                                                                Dikembalikan</label>
                                                                            <input type="date" id="returningDate"
                                                                                class="border py-3 px-2 rounded-md border-black/30"
                                                                                placeholder="Tanggal dikembalikan"
                                                                                name="returning_date"
                                                                                x-bind:value="selectedLoan.return_date" required>
                                                                        </div>
                                                                    </div>

                                                                    <select name="loan_status" id="loanStatus"
                                                                        class="border py-3 px-2 rounded-md border-black/30"
                                                                        x-bind:value="selectedLoan.status" required>
                                                                        <option value="">Pilih Status</option>
                                                                        <option value="returned">
                                                                            Dikembalikan
                                                                        </option>
                                                                        <option value="borrowed">
                                                                            Dipinjam
                                                                        </option>
                                                                        <option value="late">
                                                                            Telat
                                                                        </option>
                                                                        <option value="deadline">
                                                                            Deadline
                                                                        </option>
                                                                    </select>

                                                                    <textarea name="loan_description" x-bind:value="selectedLoan.description" id="loanDesc" placeholder="Deskripsi"
                                                                        class="flex-1 border py-3 px-2 rounded-md border-black/30"></textarea>
                                                                </div>
                                                                <div class="w-full flex justify-end items-center mt-5">
                                                                    <button type="submit"
                                                                        class="bg-primary px-3 py-1 rounded-md">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </x-slot>
                                                    </x-modal>

                                                    {{-- delete  --}}
                                                    <x-modal title="Hapus Data Peminjaman">
                                                        <x-slot name="buttonSlot">
                                                            <button type="button"
                                                                class="bg-red-600 text-white !px-3 !py-1 !rounded-xl">
                                                                <p class="text-xs truncate">Hapus</p>
                                                            </button>
                                                        </x-slot>
                                                        <x-slot name="contentSlot">
                                                            <div class="w-[400px]">
                                                                <p class="text-sm font-medium">Apakah anda yakin akan menghapus
                                                                    data peminjaman dengan peminjam bernama: <span
                                                                        class="font-bold"
                                                                        x-text="selectedLoan.member.user.username"></span>?
                                                                    Data
                                                                    yang dihapus akan hilang dari list</p>

                                                                <form action="{{ route('peminjaman.destroy') }}" method="POST"
                                                                    class="mt-3 w-full flex items-center justify-between"
                                                                    id="deleteBookForm">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="loan_id"
                                                                        x-bind:value="selectedLoan.id">

                                                                    <div x-cloak
                                                                        x-show="selectedLoan.status !=='fine' && selectedLoan.status !=='returned'"
                                                                        class="flex items-center gap-2">
                                                                        <input type="checkbox" name="return_coppies"
                                                                            id="returnBookCoppies">
                                                                        <label for="returnBookCoppies"
                                                                            class="text-sm font-medium text-black/80">Kembalikan
                                                                            stok buku</label>
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="bg-red-600 text-white !px-3 !py-1 rounded-md">
                                                                        <p class="text-sm truncate">Hapus</p>
                                                                </form>
                                                                </button>
                                                            </div>
                                                        </x-slot>
                                                    </x-modal>

                                                    {{-- create fines  --}}
                                                    <div x-cloak x-show="selectedLoan.status === 'late'">
                                                        <x-modal title="Buat Denda">
                                                            <x-slot name="buttonSlot">
                                                                <button type="button"
                                                                    class="bg-red-600 text-white !px-3 !py-1 !rounded-xl">
                                                                    <p class="text-xs truncate">Buat Denda</p>
                                                                </button>
                                                            </x-slot>
                                                            <x-slot name="contentSlot">
                                                                <div class="w-[400px] h-[350px]">
                                                                    <form action="{{ route('peminjaman.createFine') }}"
                                                                        method="POST" class="h-full flex flex-col gap-y-3">
                                                                        @csrf

                                                                        {{-- loan id  --}}
                                                                        <input type="hidden" name="loan_id"
                                                                            x-bind:value="selectedLoan.id">

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
                                                                            <option value="0">Belum selesai</option>
                                                                        </select>

                                                                        <div class="flex flex-col gap-y-1">
                                                                            <label for="inputCreateFineDate"
                                                                                class="text-sm text-black/50">Tanggal</label>
                                                                            <input type="date"
                                                                                class="rounded-md border border-black/30 px-1 py-2"
                                                                                name="date" id="inputCreateFineDate" />
                                                                        </div>

                                                                        <textarea name="description" placeholder="Deskripsi" id="createFineDescription"
                                                                            class="rounded-md border border-black/30 px-1 py-2 flex-1"></textarea>

                                                                        <div class="flex items-center justify-end">
                                                                            <button type="submit"
                                                                                class="px-2 py-1 bg-primary rounded-md">Buat
                                                                                Denda</button>
                                                                        </div>
                                                                    </form>
                                                                    </button>
                                                                </div>
                                                            </x-slot>
                                                        </x-modal>
                                                    </div>

                                                </div>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                                <div class="flex flex-col gap-y-5">
                                    <div>
                                        <p class="text-black/50 text-xs">Peminjam</p>
                                        <h1 class="text-sm" x-text="selectedLoan.member.user.username"></h1>
                                    </div>

                                    <div>
                                        <p class="text-black/50 text-xs">NISN</p>
                                        <h1 class="text-sm" x-text="selectedLoan.member.user.nisn">
                                        </h1>
                                    </div>

                                    <div>
                                        <p class="text-black/50 text-xs">Cover Buku</p>
                                        <div class="h-full mt-2">
                                            <img :src="`{{ asset('storage') }}/${selectedLoan.book.image}`" alt="Book Image"
                                                class="w-[200px] h-[250px] object-cover shadow-book-shadow rounded-md border border-gray-300" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        @endif
        </div>
        @endif
    @endauth
@endsection


<script>
    // set loan status filter 
    function setLoanStatus(status) {
        const form = document.getElementById('filterLoanForm');

        let statusLoanInput = form.querySelector('input[name="loanStatus"]');
        if (!statusLoanInput) {
            statusLoanInput = document.createElement('input');
            statusLoanInput.setAttribute('type', 'hidden');
            statusLoanInput.setAttribute('name', 'loanStatus');
            form.appendChild(statusLoanInput);
        }

        statusLoanInput.value = status;

        form.submit();
    }

    function formatCreatedAtOnUpdate(dateString) {
        const date = new Date(dateString); // Pastikan tanggalnya berupa objek Date
        const year = date.getFullYear();
        const month = (date.getMonth() + 1).toString().padStart(2,
            '0'); // Tambahkan 1 untuk bulan karena bulan dimulai dari 0
        const day = date.getDate().toString().padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // format loan date with js 
    function formatLoanDate(dateString) {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day} - ${month} - ${year}`;
    }

    // validate loan dates 
    function validateLoanDates() {
        const borrowingDate = new Date(document.getElementById('borrowingDate').value);
        const returningDate = new Date(document.getElementById('returningDate').value);

        if (returningDate <= borrowingDate) {
            alert("Tanggal dikembalikan harus setelah tanggal dipinjam.");
            document.getElementById('returningDate').value = ''; // Clear the invalid date
        }
    }


    // reset filter 
    function resetLoanFilters() {
        const form = document.querySelector('#filterLoanForm');
        form.querySelector('input[name="book_title_search"]').value = '';

        let statusLoanInput = form.querySelector('input[name="loanStatus"]');
        if (statusLoanInput) {
            statusLoanInput.value = '';
        }

        let loanCreatedAtInput = form.querySelector('input[name="loan_created_at"]');
        if (loanCreatedAtInput) {
            loanCreatedAtInput.value = '';
        }

        form.submit();
    }

    // filter by date 
    function handleLoanDateChange(dateStr) {
        const form = document.getElementById('filterLoanForm');

        let loanDateInput = form.querySelector('input[name="loan_created_at"]');
        if (!loanDateInput) {
            loanDateInput = document.createElement('input');
            loanDateInput.setAttribute('type', 'hidden');
            loanDateInput.setAttribute('name', 'loan_created_at');
            form.appendChild(loanDateInput);
        }

        loanDateInput.value = dateStr;
        form.submit();
    }
</script>
