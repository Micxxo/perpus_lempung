@extends('layout.main')
@section('content')
    <section class="px-5 md:px-8 py-3 md:py-6 flex flex-col md:flex-row items-center h-full relative">
        <div class="w-full md:w-[45%] h-full flex flex-col bg-secondary rounded-2xl pt-20 overflow-y-auto custom-scrollbar">
            <div class="mx-auto w-fit">
                <img src="{{ asset('images/logo.webp') }}" alt="logo">
            </div>
            <div class="w-full mt-8">
                <h1 class="font-semibold text-3xl md:text-4xl text-center">SELAMAT DATANG!</h1>
                <p class="text-center mt-2">Silakan masukkan detail Anda</p>
            </div>
            <div class="flex-1">
                @yield('form')
            </div>
            <div class="py-3 w-full">
                @if (Request::is('register'))
                    <p class="text-center text-sm">Sudah punya akun? <span class="underline"><a
                                href="/login">login</a></span></p>
                @else
                    <p class="text-center text-sm">Tidak punya akun? <span class="underline"><a href="/register">buat
                                akun</a></span></p>
                @endif
            </div>

        </div>
        <div class="flex-1 px-8 py-5 hidden md:flex gap-2 justify-center items-center">
            <div>
                <img src="{{ asset('images/logo.webp') }}" alt="logo">
            </div>
            <h1 class="text-4xl">Perpustakaan <br>Lempuing</h1>
        </div>


        <div x-data="{ showSuccess: {{ session('success') ? 'true' : 'false' }}, showErrors: {{ $errors->any() ? 'true' : 'false' }} }" x-init="setTimeout(() => {
            showSuccess = false;
            showErrors = false;
        }, 2000)">
            <div x-show="showSuccess" class="absolute bottom-10 right-14 flex flex-col gap-y-5">
                <x-success-alert>{{ session('success') }}</x-success-alert>
            </div>

            <div x-show="showErrors" class="absolute bottom-10 right-14 flex flex-col gap-y-5">
                @foreach ($errors->all() as $index => $error)
                    <x-error-alert>{{ $error }}</x-error-alert>
                @endforeach
            </div>
        </div>

    </section>
@endsection
