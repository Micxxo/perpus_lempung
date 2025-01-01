@extends('layout.landing')

@section('section')
    <div class="my-5">
        {{-- carousel  --}}
        <div x-data="carousel()" class="relative mx-auto rounded-3xl" id="home">
            <!-- Carousel Images -->
            <div class="overflow-hidden relative rounded-3xl">
                <div x-ref="carouselImages" class="flex transition-transform ease-in-out duration-300 h-[calc(100vh-150px)]">
                    <template x-for="(image,
                    index) in images" :key="index">
                        <div class="flex-none w-full">
                            <img :src="image" alt="Carousel Image" class="w-full h-full rounded-3xl object-cover">
                        </div>
                    </template>
                </div>
            </div>

            <div class="absolute top-1/2 left-1/2 -translate-x-1/2">
                <p class="font-semibold text-4xl text-white text-center">Perpustakaan <br> Lempuing</p>
            </div>

            <!-- Navigation Buttons -->
            <button @click="prevImage()" class="absolute top-1/2 left-4 transform -translate-y-1/2 p-3 text-white">
                <span class="material-symbols-outlined">
                    arrow_back_ios
                </span> </button>
            <button @click="nextImage()" class="absolute top-1/2 right-4 transform -translate-y-1/2 p-3 text-white">
                <span class="material-symbols-outlined">
                    arrow_forward_ios
                </span>
            </button>
        </div>

        {{-- collection  --}}
        <div id="collection" class="mt-8">
            <div
                class="w-full h-auto md:h-[368px] bg-secondary rounded-3xl px-10 md:px-14 py-10 flex flex-col md:flex-row gap-10">
                <div class="w-full md:w-[35%] h-full">
                    <img src="images/library2.webp" alt="library" class="w-full h-full object-cover rounded-xl">
                </div>
                <div class="flex-1 mt-0 md:mt-5">
                    <h1 class="font-medium text-2xl">Koleksi Perpustakaan</h1>
                    <p class="mt-1 text-base">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eu laoreet
                        magna,
                        a
                        porttitor ligula.
                        Nullam semper augue vel nisi venenatis tincidunt. Sed varius metus vel nulla congue, at posuere eros
                        euismod</p>
                </div>
            </div>

            <div
                class="w-full flex flex-col bg-secondary rounded-3xl px-5 md:px-8 py-7 mt-8 min-h-[600px] max-h-[800px] overflow-y-auto">
                <div x-data>
                    <x-badge>Koleksi</x-badge>

                    <form @submit.prevent="$store.dataStore.setSearch($refs.searchInput.value)"
                        class="mt-5 flex flex-col md:flex-row items-center gap-3">
                        <input type="text" name="search" placeholder="Cari judul buku atau penerbit"
                            class="border border-[#B8B8B8] px-3 py-2 rounded-md w-full md:w-[376px]" x-ref="searchInput"
                            x-model="$store.dataStore.searchQuery">

                        <button type="submit"
                            class="border border-black rounded-lg bg-transparent px-8 py-2 w-full md:w-fit">
                            Cari
                        </button>
                    </form>

                </div>
                <div x-data x-init="$store.dataStore.fetch()" class="flex-1">
                    {{-- map data buku disini  --}}
                    <template x-if="$store.dataStore.books.length > 0 && !$store.dataStore.loading">
                        <div class="grid grid-cols-3 gap-x-5 gap-y-5 mt-5">
                            <template x-for="book in $store.dataStore.books.slice(0, 6)" :key="book.id">
                                <div class="flex gap-10 p-2">
                                    <div class="h-full">
                                        <img :src="`{{ asset('storage') }}/${book.image}`" alt="Book Imgae"
                                            class="w-[200px] h-[257px] object-cover shadow-book-shadow rounded-md" />
                                    </div>
                                    <div class="mt-4">
                                        <h1 x-text="book.name" class="font-medium text-xl"></h1>
                                        <p x-text="book.authors" class="text-sm text-black/50"></p>
                                        <x-badge class="mt-2 !bg-accent !text-white px-5 !py-0.8 !rounded-xl">
                                            <p x-text="book.status" variant="primary" class="capitalize text-sm"></p>
                                        </x-badge>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>

                    <div class="h-96 w-full flex items-center justify-center" x-show="$store.dataStore.loading">
                        <x-spinner />
                    </div>

                    <div class="w-full translate-y-1/2"
                        x-show="$store.dataStore.books.length === 0 && !$store.dataStore.loading">
                        <x-book-error-state>
                            <div class="mt-4 md:mt-7">
                                <p class="font-semibold text-3xl md:text-4xl text-center md:text-left">Buku tidak
                                    <br>ditemukan
                                </p>
                            </div>
                        </x-book-error-state>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


<script>
    function carousel() {
        return {
            currentIndex: 0,
            images: [
                'images/school.webp',
                'images/library1.webp',
                'images/library2.webp',
            ],
            prevImage() {
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                } else {
                    this.currentIndex = this.images.length - 1;
                }
                this.updateCarouselPosition();
            },
            nextImage() {
                if (this.currentIndex < this.images.length - 1) {
                    this.currentIndex++;
                } else {
                    this.currentIndex = 0;
                }
                this.updateCarouselPosition();
            },
            goToImage(index) {
                this.currentIndex = index;
                this.updateCarouselPosition();
            },
            updateCarouselPosition() {
                this.$refs.carouselImages.style.transform = `translateX(-${this.currentIndex * 100}%)`;
            },
        };
    }

    document.addEventListener("alpine:init", () => {
        Alpine.store("dataStore", {
            books: [],
            searchQuery: "",
            loading: false,

            async fetch() {
                this.loading = true;
                const queryParam = this.searchQuery ? `?search=${this.searchQuery}` : "";
                try {
                    const response = await fetch(`/books${queryParam}`);
                    const data = await response.json();
                    this.books = data.data;
                } catch (error) {
                    console.error("Error fetching books:", error);
                } finally {
                    this.loading = false;
                }
            },

            setSearch(query) {
                this.searchQuery = query;
                this.fetch();
            }
        });
    });
</script>
