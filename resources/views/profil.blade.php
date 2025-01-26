@extends('layout.dashboard')

@section('section')
    <div class="px-10 py-8 flex items-center w-full h-full">
        <div class="w-[60%] h-full flex flex-col">
            <x-badge class="px-4 rounded-md">
                <p class="font-medium">Profil Anda</p>
            </x-badge>

            {{-- update account form  --}}
            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" x-ref="form"
                x-data="{ formReset() { $refs.form.reset(); } }" class="w-full flex items-center flex-col flex-1 ">
                @method('PUT')
                @csrf
                <div x-data="{ imagePreview: '{{ old('profile', $user->profile) ? asset('storage/' . old('profile', $user->profile)) : null }}' }"
                    class="w-[150px] h-[150px] rounded-full bg-[#D9D9D9] flex items-center justify-center cursor-pointer group relative">

                    <input x-ref="imageInput" type="file" class="hidden"
                        @change="imagePreview = URL.createObjectURL($event.target.files[0])" name="profile" />

                    <!-- Preview Image -->
                    <img x-show="imagePreview" :src="imagePreview" alt="Image Preview"
                        class="w-full h-full object-cover rounded-full" />

                    <!-- Default Icon -->
                    <span @click="!imagePreview && $refs.imageInput.click()" x-show="!imagePreview"
                        class="material-symbols-outlined" style="font-size: 72px">
                        person
                    </span>

                    <!-- Delete Button -->
                    <div x-show="imagePreview"
                        class="w-full h-full bg-black/25 absolute rounded-full hidden group-hover:flex items-center justify-center">
                        <span class="material-symbols-outlined text-red-600" style="font-size: 40px"
                            @click="imagePreview = null">
                            delete
                        </span>
                    </div>
                </div>

                <div class="mt-5 w-1/2 space-y-3 flex-1 flex flex-col">
                    <div class="flex flex-col gap-y-1">
                        <label for="nisn">NISN</label>
                        <input type="text" name="nisn" class="border border-black/30 rounded-[4px] p-1"
                            value="{{ old('nisn', $user->nisn) }}" />
                    </div>

                    <div class="flex flex-col gap-y-1">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="border border-black/30 rounded-[4px] p-1"
                            value="{{ old('username', $user->username) }}" />
                    </div>

                    <div class="flex flex-col gap-y-1">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="border border-black/30 rounded-[4px] p-1"
                            value="{{ old('email', $user->email) }}" />
                    </div>

                    <div class="flex flex-col gap-y-1 flex-1" x-data="{ showConfirm: false }">
                        <label for="password_confirmation">Password</label>
                        <div class="flex items-center border border-black/30 rounded-[4px]">
                            <input :type="showConfirm ? 'text' : 'password'" name="password"
                                class="border-none rounded-[4px] p-1 flex-1 focus:outline-none" placeholder="Password" />
                            <button type="button" @click="showConfirm = !showConfirm"
                                class="pr-2 flex items-center justify-center">
                                <span class="material-symbols-outlined"
                                    x-text="showConfirm ? 'visibility_off' : 'visibility'"></span>
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col gap-y-1 flex-1" x-data="{ showConfirm: false }">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <div class="flex items-center border border-black/30 rounded-[4px]">
                            <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation"
                                class="border-none rounded-[4px] p-1 flex-1 focus:outline-none" placeholder="Password" />
                            <button type="button" @click="showConfirm = !showConfirm"
                                class="pr-2 flex items-center justify-center">
                                <span class="material-symbols-outlined"
                                    x-text="showConfirm ? 'visibility_off' : 'visibility'"></span>
                            </button>
                        </div>
                    </div>


                    <div class="flex items-center justify-end flex-1">
                        <div class="flex items-center gap-5">
                            <button type="button" @click="formReset()"
                                class="bg-primary rounded-md border-2 border-black px-8 py-1 font-medium">
                                Reset
                            </button>
                            <button type="submit"
                                class="bg-transparent rounded-md border-2 border-black px-3 py-1 font-medium">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="flex-1 h-full relative rounded-2xl">
            <img src="{{ asset('images/profile-ornament.png') }}" alt="Example Image"
                class="w-full h-full object-cover rounded-2xl" />
            <div class="absolute inset-0 flex justify-center items-center">
                @auth
                    @if (auth()->user()->role_id === 1 && !auth()->user()->is_member)
                        <x-modal title=" ">
                            <x-slot name="buttonSlot">
                                <button class="bg-transparent rounded-xl border-2 border-primary text-white py-2 px-8">
                                    Register Member
                                </button>
                            </x-slot>

                            <x-slot name="contentSlot">
                                <div class="w-[500px] flex flex-col items-center justify-center">
                                    <h1 class="text-xl text-center font-semibold mt-5">Bergabunglah menjadi anggota dan
                                        dapatkan
                                        buku Anda
                                        sekarang!</h1>

                                    @if ($user->profile)
                                        <!-- Jika user memiliki foto profil -->
                                        <div class="w-[150px] h-[150px] rounded-full mt-5">
                                            <img :src="`{{ asset('storage/' . $user->profile) }}`" alt="Image Preview"
                                                class="w-full h-full object-cover rounded-full" />
                                        </div>
                                    @else
                                        <!-- Jika user tidak memiliki foto profil -->
                                        <div
                                            class="w-[150px] h-[150px] rounded-full mt-5 bg-[#D9D9D9] flex items-center justify-center">
                                            <span class="material-symbols-outlined" style="font-size: 72px">
                                                person
                                            </span>
                                        </div>
                                        <p class="mt-2 text-sm text-red-600 font-medium">Anda harus membuat foto profil terlebih
                                            dahulu!
                                        </p>
                                    @endif

                                    <p class="font-medium mt-5">{{ auth()->user()->username }}</p>
                                    <form class="mt-10" action="{{ route('member.store') }}" method="POST">
                                        @csrf
                                        <button type="submit" @disabled(!$user->profile)
                                            class="bg-primary rounded-xl px-10 py-1 disabled:bg-gray-300 disabled:cursor-not-allowed disabled:text-black/50">Join</button>
                                    </form>
                                </div>
                            </x-slot>
                        </x-modal>
                    @else
                        @if (auth()->user()->role_id === 1)
                            <h1 class="text-white font-medium">Anda merupakan member</h1>
                        @endif
                    @endif
                @endauth

            </div>
        </div>
    </div>
@endsection


<script>
    document.getElementById('resetButton').addEventListener('click', function() {
        const form = document.getElementById('userForm');
        form.reset();
    });
</script>
