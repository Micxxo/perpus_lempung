@extends('layout.auth')

@section('form')
    <form action="" class="mt-10 flex flex-col items-center gap-y-8">
        <input
            class="bg-transparent rounded-none border-b border-black w-[80%] py-1 placeholder:text-black focus:outline-none"
            required ="text" placeholder="Username">
        <input
            class="bg-transparent rounded-none border-b border-black w-[80%] py-1 placeholder:text-black focus:outline-none"
            required ="text" placeholder="Email">
        <div x-data="{ show: false }" class="w-[80%] flex items-center border-b border-black py-1">
            <input class="bg-transparent flex-1 rounded-none placeholder:text-black focus:outline-none" required
                :type="show ? 'text' : 'password'" placeholder="Password">
            <button type="button" @click="show = !show" class="flex items-center justify-center">
                <span class="material-symbols-outlined" x-text="show ? 'visibility_off' : 'visibility'"></span>
            </button>
        </div>
        <div x-data="{ show: false }" class="w-[80%] flex items-center border-b border-black py-1">
            <input class="bg-transparent flex-1 rounded-none placeholder:text-black focus:outline-none" required
                :type="show ? 'text' : 'password'" placeholder="Confirm Password">
            <button type="button" @click="show = !show" class="flex items-center justify-center">
                <span class="material-symbols-outlined" x-text="show ? 'visibility_off' : 'visibility'"></span>
            </button>
        </div>
        <x-primary-button type="submit" class="w-[80%] py-3 md:py-5 rounded-full text-lg">Register</x-primary-button>
    </form>
@endsection
