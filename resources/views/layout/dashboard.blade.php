@extends('layout.main')
@section('content')
    <section class="flex w-full h-full relative">
        <x-sidebar />
        <div class="flex-1 flex flex-col p-5">
            <x-header />
            <div class="w-full flex-1 bg-white mt-5 rounded-xl shadow-blur-xs overflow-y-auto">
                @yield('section')
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

    </section>
@endsection
