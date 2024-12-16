@extends('layout.auth')

@section('form')
    <form action="{{ route('auth.login') }}" method="POST" class="mt-10 flex flex-col items-center gap-y-10">
        @csrf
        <input
            class="bg-transparent rounded-none border-b border-black w-[80%] py-1 placeholder:text-black focus:outline-none"
            required ="text" placeholder="Email" name="email" value="{{ session('email') ? session('email') : old('email') }}"
            autofocus>
        <div x-data="{ show: false }" class="w-[80%] flex items-center border-b border-black py-1">
            <input class="bg-transparent flex-1 rounded-none placeholder:text-black focus:outline-none" required
                :type="show ? 'text' : 'password'" placeholder="Password" name="password">
            <button type="button" @click="show = !show" class="flex items-center justify-center">
                <span class="material-symbols-outlined" x-text="show ? 'visibility_off' : 'visibility'"></span>
            </button>
        </div>
        <x-primary-button type="submit"
            class="w-[80%] mt-0 md:mt-3 py-3 md:py-5 rounded-full text-lg">Login</x-primary-button>
    </form>
@endsection
