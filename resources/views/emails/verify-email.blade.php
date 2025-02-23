@extends('layout.main')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 px-6 relative">
        <div class="max-w-md w-1/4 bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800">Verifikasi Email Anda</h2>
            <p class="mt-2 text-sm text-gray-600">
                Kami telah mengirimkan email verifikasi ke alamat email Anda.
                Silakan periksa kotak masuk atau folder spam Anda.
            </p>

            <div class="mt-5">
                <p class="text-gray-600">Belum menerima email?</p>
                <form method="POST" action="{{ route('verification.send') }}" class="mt-1">
                    @csrf
                    <button type="submit"
                        class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <p class="mt-10 text-gray-500 text-xs text-center">
                    Jika Anda sudah memverifikasi email, silakan <a href="{{ route('login') }}"
                        class="text-blue-500 hover:underline">login</a>.
                </p>
            </div>
        </div>

        <div x-data="{
            showSuccess: {{ session('success') ? 'true' : 'false' }},
            showErrors: {{ $errors->any() || session('error') ? 'true' : 'false' }}
        }" x-init="setTimeout(() => {
            showSuccess = false;
            showErrors = false;
        }, 2000)">
            <div x-cloak x-show="showSuccess" class="absolute bottom-10 right-14 flex flex-col gap-y-5">
                <x-success-alert>{{ session('success') }}</x-success-alert>
            </div>

            <div x-cloak x-show="showErrors" class="absolute bottom-10 right-14 flex flex-col gap-y-5">
                @if (session('error'))
                    <x-error-alert>{{ session('error') }}</x-error-alert>
                @endif
                @foreach ($errors->all() as $error)
                    <x-error-alert>{{ $error }}</x-error-alert>
                @endforeach
            </div>
        </div>
    </div>
@endsection
