@extends('layout.dashboard')

@section('section')
    <div class="p-10 flex items-center w-full h-full">
        <div class="w-[60%] h-full flex flex-col">
            <x-badge class="px-4 rounded-md">
                <p class="font-medium">Profil Anda</p>
            </x-badge>
            <div class="w-full flex items-center flex-col mt-5 flex-1">
                <div class="w-[150px] h-[150px] rounded-full bg-[#D9D9D9] flex items-center justify-center cursor-pointer">
                    <span class="material-symbols-outlined" style="font-size: 72px">
                        person
                    </span>
                </div>

                <form action="" class="mt-5 w-1/2 space-y-7 flex-1 flex flex-col">
                    <div class="flex flex-col gap-y-2">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="border border-black/30 rounded-[4px] p-1"
                            value="{{ old('username', $user->username) }}" />
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="border border-black/30 rounded-[4px] p-1"
                            value="{{ old('email', $user->email) }}" />
                    </div>

                    <div class="flex flex-col gap-y-2 flex-1">
                        <label for="password">Password</label>
                        <div class="flex items-center border border-black/30 rounded-[4px]">
                            <input type="password" name="password"
                                class="border-none rounded-[4px] p-1 flex-1 focus:outline-none" placeholder="Password" />
                            <div class="pr-2 flex items-center justify-center">
                                <span class="material-symbols-outlined">
                                    edit
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end flex-1">
                        <div class="flex items-center gap-5">
                            <button type="button"
                                class="bg-primary rounded-md border-2 border-black px-8 py-1 font-medium">
                                Reset
                            </button>
                            <button type="submit"
                                class="bg-transparent rounded-md border-2 border-black px-3 py-1 font-medium">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>

            </div>
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

                                    <div
                                        class="w-[150px] h-[150px] rounded-full bg-[#D9D9D9] flex items-center justify-center cursor-pointer mt-8">
                                        <span class="material-symbols-outlined" style="font-size: 72px">
                                            person
                                        </span>
                                    </div>
                                    <p class="font-medium mt-5">{{ auth()->user()->username }}</p>
                                    <form class="mt-10" action="{{ route('member.store') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-primary rounded-xl px-10 py-1">Join</button>
                                    </form>
                                </div>
                            </x-slot>
                        </x-modal>
                    @else
                        <h1 class="text-white font-medium">Anda merupakan member</h1>
                    @endif
                @endauth

            </div>
        </div>
    </div>
@endsection
