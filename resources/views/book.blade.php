@extends('layout.dashboard')

@section('section')
    <div class="p-10 flex flex-col h-full">
        <x-badge class="px-4 rounded-md">
            <p class="font-medium">Daftar Buku</p>
        </x-badge>

        <!-- Form untuk mencari buku -->
        <div class="flex items-center justify-between">
            <form method="GET" action="{{ route('buku') }}" class="w-full flex items-center gap-5 mt-6 flex-1"
                id="filterForm">
                {{-- input for save status value  --}}
                <input type="hidden" name="status" id="statusInput" value="{{ old('status', $status) }}" />

                <div class="flex items-center w-1/4 border border-black/30 rounded-md">
                    <input type="text"
                        class="border-none bg-white flex-1 py-1.5 px-2 rounded-md focus:outline-none placeholder:text-black/50"
                        placeholder="Cari nama atau penerbit buku" name="search" value="{{ old('search', $search) }}" />
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
                            <div
                                class="text-sm font-medium px-5 py-1 rounded-xl {{ $status == 'tersedia' ? 'bg-accent text-white' : ($status == 'out-stock' ? 'bg-red-600 text-white' : 'bg-primary') }}">
                                {{ $status ? ucfirst($status) : 'Semua' }}
                            </div>

                            <span class="material-symbols-outlined text-black/50" style="font-size: 28px">
                                keyboard_arrow_down
                            </span>
                        </div>
                    </x-slot>

                    <x-slot name="contentSlot">
                        <div class="space-y-1">
                            <div class="p-2 rounded-sm flex items-center gap-2 cursor-pointer {{ $status == '' ? 'bg-gray-100' : 'hover:bg-gray-100 ' }}"
                                onclick="setStatus('')">
                                <div class="bg-primary text-black text-sm font-medium px-5 py-0.5 rounded-xl">Semua</div>
                            </div>
                            <div class="p-2 rounded-sm flex items-center gap-2 cursor-pointer {{ $status == 'tersedia' ? 'bg-gray-100' : 'hover:bg-gray-100 ' }}"
                                onclick="setStatus('available')">
                                <div class="bg-accent text-white text-sm font-medium px-5 py-0.5 rounded-xl ">
                                    Tersedia
                                </div>
                            </div>
                            <div class="p-2 rounded-sm flex items-center gap-2 cursor-pointer {{ $status == 'out-stock' ? 'bg-gray-100' : 'hover:bg-gray-100 ' }}"
                                onclick="setStatus('out-stock')">
                                <div class="bg-red-600 text-white text-sm font-medium px-5 py-0.5 rounded-xl">Tidak ada stok
                                </div>
                            </div>
                        </div>
                    </x-slot>
                </x-dropdown>

                @if ($search || $status)
                    <button type="button" onclick="resetFilters()"
                        class="px-8 py-1.5 bg-primary text-black font-semibold rounded-md">Reset</button>
                @endif
            </form>
            @auth
                @if (Auth::user()->role_id === 2)
                    <x-modal title="Tambah Buku">
                        <x-slot name="buttonSlot">
                            <button type="button" class="px-5 py-1.5 bg-accent text-white font-semibold rounded-md">Tambah
                                Buku</button>
                        </x-slot>

                        <x-slot name="contentSlot">
                            <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data"
                                class="w-[500px] h-[400px] flex flex-col" id="createBookForm" x-data="bookForm()">
                                @csrf
                                <div class="flex flex-1 w-full gap-5 ">
                                    <div class="relative group">
                                        <div class="h-full w-56 border-accent rounded-md border border-dashed flex items-center justify-center cursor-pointer"
                                            @click="!image && $refs.fileInput.click()">
                                            <div class="flex flex-col items-center justify-center" id="imagePreviewContainer">
                                                <!-- Default placeholder -->
                                                <span class="material-symbols-outlined text-gray-500" x-show="!image">
                                                    image
                                                </span>
                                                <p class="text-sm text-neutral-500" x-show="!image">Cover Buku</p>
                                            </div>
                                            <img x-show="image" :src="image"
                                                class="w-full h-full object-cover rounded-md" alt="Cover Buku"
                                                draggable="false">
                                            <input type="file" name="image" id="imageInput" x-ref="fileInput"
                                                class="hidden" accept="image/*" @change="previewImage" />
                                        </div>
                                        <div x-show="image" class="absolute top-2 right-2 hidden group-hover:block">
                                            <button type="button" @click="removeImage"
                                                class="bg-red-500 text-white p-1 rounded-md">
                                                <span class="material-symbols-outlined">
                                                    delete
                                                </span></button>
                                        </div>
                                    </div>
                                    <div class="flex-1 flex flex-col gap-y-2 h-full">
                                        <input type="text" name="name"
                                            class="border border-gray-300 rounded-md w-full placeholder:text-gray-500 placeholder:text-sm px-3 py-1.5"
                                            required placeholder="Nama Buku" />
                                        <input type="number" name="coppies"
                                            class="border border-gray-300 rounded-md w-full placeholder:text-gray-500 placeholder:text-sm px-3 py-1.5"
                                            required placeholder="Jumlah Tersedia" />
                                        <input type="number" name="year"
                                            class="border border-gray-300 rounded-md w-full placeholder:text-gray-500 placeholder:text-sm px-3 py-1.5"
                                            required placeholder="Tahun Terbit" />
                                        <input type="text" name="authors"
                                            class="border border-gray-300 rounded-md w-full placeholder:text-gray-500 placeholder:text-sm px-3 py-1.5"
                                            required placeholder="Penulis" />
                                        <input type="text" name="genre"
                                            class="border border-gray-300 rounded-md w-full placeholder:text-gray-500 placeholder:text-sm px-3 py-1.5"
                                            required placeholder="Genre" />
                                        <textarea type="text" name="description"
                                            class="border border-gray-300 flex-1 rounded-md w-full placeholder:text-gray-500 placeholder:text-sm px-3 py-1.5"
                                            placeholder="Deskripsi"></textarea>
                                    </div>
                                </div>
                                <div class="w-full flex justify-end items-center mt-5">
                                    <button type="submit" class="bg-primary px-3 py-1 rounded-md">Simpan</button>
                                </div>
                            </form>
                        </x-slot>
                    </x-modal>
                @endif
            @endauth
        </div>


        <!-- Menampilkan buku -->
        <div class="flex-1 flex flex-col overflow-y-auto custom-scrollbar">
            @if ($books->isEmpty())
                <div class="w-full h-full">
                    <x-book-error-state>
                        <div class="mt-4 md:mt-7">
                            <p class="font-semibold text-3xl md:text-4xl text-center md:text-left">Buku tidak
                                <br>ditemukan
                            </p>
                        </div>
                    </x-book-error-state>
                </div>
            @else
                <div class="grid grid-cols-3 gap-x-8 gap-y-6 mt-8">
                    @foreach ($books as $book)
                        <div class="flex gap-8 justify-start">
                            <div class="h-full">
                                <img src="{{ asset('storage/' . $book->image) }}" alt="Book Image"
                                    class="w-[150px] h-[200px] object-cover shadow-book-shadow rounded-md border border-gray-300" />
                            </div>
                            <div class="flex-1">
                                <h1 class="font-medium text-xl">{{ $book->name }}</h1>
                                <p class="text-sm text-black/50">{{ $book->authors }}</p>
                                <div class="mt-3 flex flex-col gap-y-2">
                                    <div class="flex items-center gap-3">
                                        <x-badge :class="($book->status === 'out-stock') ? 'bg-red-600 text-white !px-3 !py-1 !rounded-xl' : '!bg-accent text-white !px-3 !py-1 !rounded-xl'">
                                            <p class="capitalize text-xs truncate">
                                                @if ($book->status === 'available')
                                                    Tersedia
                                                @elseif ($book->status === 'out-stock')
                                                    Tidak ada stok
                                                @else
                                                    {{ $book->status }}
                                                @endif
                                            </p>
                                        </x-badge>
                                        <x-modal title="Detail Buku">
                                            <x-slot name="buttonSlot">
                                                <x-primary-button class="px-3 py-1 !rounded-xl">
                                                    <p variant="primary" class="capitalize text-xs">
                                                    <p class="text-xs underline">Detail</p>
                                                    </p>
                                                </x-primary-button>
                                            </x-slot>
                                            <x-slot name="contentSlot">
                                                <div class="flex gap-5 w-[500px] h-[300px]">
                                                    <div class="h-full">
                                                        <img src="{{ asset('storage/' . $book->image) }}"
                                                            alt="Book Image"
                                                            class="w-[200px] h-full object-cover rounded-md border border-gray-300" />
                                                    </div>
                                                    <div class="h-full w-[2px] bg-gray-200"></div>
                                                    <div class="flex-1 space-y-2">
                                                        <h1 class="text-base font-semibold">{{ $book->name }}</h1>
                                                        <p class="text-sm">{{ $book->description }}</p>
                                                        <p class="font-bold text-sm">Author: <span
                                                                class="font-medium">{{ $book->authors }}</span></p>
                                                        <p class="font-bold text-sm">Genre: <span
                                                                class="font-medium">{{ $book->genre }}</span></p>
                                                        @auth
                                                            @if (Auth::user()->role_id === 2)
                                                                <p class="font-bold text-sm">stok: <span
                                                                        class="font-medium">{{ $book->coppies }}</span></p>
                                                            @endif
                                                        @endauth
                                                    </div>
                                                </div>
                                            </x-slot>
                                        </x-modal>
                                    </div>
                                    @auth
                                        @if (Auth::user()->role_id === 2)
                                            <div class="flex items-center gap-3">

                                                {{-- delete books  --}}
                                                <x-modal title="Hapus Buku">
                                                    <x-slot name="buttonSlot">
                                                        <button type="button"
                                                            class="bg-red-600 text-white !px-3 !py-1 !rounded-xl">
                                                            <p class="text-xs truncate">Hapus</p>
                                                        </button>
                                                    </x-slot>
                                                    <x-slot name="contentSlot">
                                                        <div class="w-[400px]">
                                                            <p class="text-sm font-medium">Apakah anda yakin akan menghapus
                                                                buku <span class="font-bold">{{ $book->name }}</span>? Buku
                                                                yang dihapus akan hilang dari list</p>

                                                            <form action="{{ route('buku.destroy', $book->id) }}"
                                                                method="POST"
                                                                class="mt-3 w-full flex items-center justify-end"
                                                                id="deleteBookForm">
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

                                                {{-- update books  --}}
                                                <x-modal title="Update Buku">
                                                    <x-slot name="buttonSlot">
                                                        <button type="button"
                                                            class="bg-green-600 text-white !px-3 !py-1 !rounded-xl">
                                                            <p class="text-xs truncate">Update</p>
                                                        </button>
                                                    </x-slot>

                                                    <x-slot name="contentSlot">
                                                        <form action="{{ route('buku.update', $book->id) }}" method="POST"
                                                            enctype="multipart/form-data"
                                                            class="w-[500px] h-[400px] flex flex-col" id="createBookForm"
                                                            x-data="bookForm('{{ $book->image ? asset('storage/' . $book->image) : null }}')">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="flex flex-1 w-full gap-5 ">
                                                                <div class="relative group">
                                                                    <div class="h-full w-56 border-accent rounded-md border border-dashed flex items-center justify-center cursor-pointer"
                                                                        @click="!image && $refs.fileInput.click()">
                                                                        <div class="flex flex-col items-center justify-center"
                                                                            id="imagePreviewContainer">
                                                                            <!-- Default placeholder -->
                                                                            <span
                                                                                class="material-symbols-outlined text-gray-500"
                                                                                x-show="!image">
                                                                                image
                                                                            </span>
                                                                            <p class="text-sm text-neutral-500"
                                                                                x-show="!image">Cover Buku</p>
                                                                        </div>
                                                                        <img x-show="image" :src="image"
                                                                            class="w-full h-full object-cover rounded-md"
                                                                            alt="Cover Buku" draggable="false">
                                                                        <input type="file" name="image" id="imageInput"
                                                                            x-ref="fileInput" class="hidden" accept="image/*"
                                                                            @change="previewImage" />
                                                                    </div>
                                                                    <div x-show="image"
                                                                        class="absolute top-2 right-2 hidden group-hover:block">
                                                                        <button type="button" @click="removeImage"
                                                                            class="bg-red-500 text-white p-1 rounded-md">
                                                                            <span class="material-symbols-outlined">
                                                                                delete
                                                                            </span></button>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-1 flex flex-col gap-y-2 h-full">
                                                                    <input type="text" name="name"
                                                                        class="border border-gray-300 rounded-md w-full placeholder:text-gray-500 placeholder:text-sm px-3 py-1.5"
                                                                        required value="{{ $book->name }}"
                                                                        placeholder="Nama Buku" />
                                                                    <input type="number" name="coppies"
                                                                        class="border border-gray-300 rounded-md w-full placeholder:text-gray-500 placeholder:text-sm px-3 py-1.5"
                                                                        required value="{{ $book->coppies }}"
                                                                        placeholder="Jumlah Tersedia" />
                                                                    <input type="number" name="year"
                                                                        class="border border-gray-300 rounded-md w-full placeholder:text-gray-500 placeholder:text-sm px-3 py-1.5"
                                                                        required value="{{ $book->year }}"
                                                                        placeholder="Tahun Terbit" />
                                                                    <input type="text" name="authors"
                                                                        class="border border-gray-300 rounded-md w-full placeholder:text-gray-500 placeholder:text-sm px-3 py-1.5"
                                                                        required value="{{ $book->authors }}"
                                                                        placeholder="Penulis" />
                                                                    <input type="text" name="genre"
                                                                        class="border border-gray-300 rounded-md w-full placeholder:text-gray-500 placeholder:text-sm px-3 py-1.5"
                                                                        required value="{{ $book->genre }}"
                                                                        placeholder="Genre" />
                                                                    <textarea type="text" name="description"
                                                                        class="border border-gray-300 flex-1 rounded-md w-full placeholder:text-gray-500 placeholder:text-sm px-3 py-1.5"
                                                                        placeholder="Deskripsi">{{ $book->description }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="w-full flex justify-end items-center mt-5">
                                                                <button type="submit"
                                                                    class="bg-primary px-3 py-1 rounded-md">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </x-slot>
                                                </x-modal>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mt-8">
            {{ $books->appends(request()->except('page'))->links('vendor.pagination.default') }} </div>
    </div>
@endsection

<script>
    function bookForm(defaultImage = null) {
        return {
            image: defaultImage,
            previewImage(event) {
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.image = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },

            removeImage() {
                this.image = null;
                this.$refs.fileInput.value = null;
            }
        };
    }

    function setStatus(status) {
        const form = document.getElementById('filterForm');

        let statusInput = form.querySelector('input[name="status"]');
        if (!statusInput) {
            statusInput = document.createElement('input');
            statusInput.setAttribute('type', 'hidden');
            statusInput.setAttribute('name', 'status');
            form.appendChild(statusInput);
        }

        statusInput.value = status;

        form.submit();
    }

    function resetFilters() {
        const form = document.querySelector('#filterForm');
        form.querySelector('input[name="search"]').value = '';

        let statusInput = form.querySelector('input[name="status"]');
        if (statusInput) {
            statusInput.value = '';
        }

        form.submit();
    }
</script>
