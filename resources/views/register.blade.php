@extends('layout.auth')

@section('form')
    <form action="{{ route('auth.registerStudent') }}" method="POST" class="mt-10 flex flex-col items-center gap-y-8 ">
        @csrf

        <div class="flex flex-col w-[80%] ">
            <input
                class="bg-transparent rounded-none border-b border-black w-full py-1 placeholder:text-black focus:outline-none"
                required type="number" name="nisn" placeholder="NISN" autofocus>
            @error('nisn')
                <span class="text-red-600 text-left mt-2">{{ $message }}</span>
            @enderror

        </div>

        <div class="flex flex-col w-[80%]">
            <input
                class="bg-transparent rounded-none border-b border-black w-full py-1 placeholder:text-black focus:outline-none"
                required type="text" name="username" placeholder="Username" autofocus>
            @error('username')
                <span class="text-red-600 text-left mt-2">{{ $message }}</span>
            @enderror

        </div>

        <div class="flex flex-col w-[80%]">
            <input
                class="bg-transparent rounded-none border-b border-black wfull py-1 placeholder:text-black focus:outline-none"
                required ="text" name="email" placeholder="Email">
            @error('email')
                <span class="text-red-600 text-left mt-2">{{ $message }}</span>
            @enderror
        </div>


        <div class="flex flex-col w-[80%]">
            <div x-data="{ show: false }" class="w-full flex items-center border-b border-black py-1">
                <input class="bg-transparent flex-1 rounded-none placeholder:text-black focus:outline-none" required
                    :type="show ? 'text' : 'password'" name="password" placeholder="Password">
                <button type="button" @click="show = !show" class="flex items-center justify-center">
                    <span class="material-symbols-outlined" x-text="show ? 'visibility_off' : 'visibility'"></span>
                </button>
            </div>
            @error('password')
                <span class="text-red-600 text-left mt-2">{{ $message }}</span>
            @enderror
        </div>


        <div class="flex flex-col w-[80%]">
            <div x-data="{ show: false }" class="w-full flex items-center border-b border-black py-1">
                <input class="bg-transparent flex-1 rounded-none placeholder:text-black focus:outline-none" required
                    :type="show ? 'text' : 'password'" placeholder="Confirm Password" name="password_confirmation">
                <button type="button" @click="show = !show" class="flex items-center justify-center">
                    <span class="material-symbols-outlined" x-text="show ? 'visibility_off' : 'visibility'"></span>
                </button>
            </div>
            @error('password_confirmation')
                <span class="text-red-600 text-left mt-2">{{ $message }}</span>
            @enderror
        </div>


        <x-primary-button type="submit" class="w-[80%] py-3 md:py-5 rounded-full text-lg">Register</x-primary-button>
    </form>
@endsection

<script>
    let isFormDirty = false;

    document.addEventListener("input", () => {
        isFormDirty = true;
    });

    window.addEventListener("beforeunload", function(event) {
        if (isFormDirty) {
            event.preventDefault();
        }
    });

    document.addEventListener("submit", () => {
        isFormDirty = false;
    });
</script>
