@extends('layout.main')
@section('content')
    <section class="flex w-full h-full">
        <x-sidebar />
        <div class="flex-1 flex flex-col p-5">
            <x-header />
            <div class="w-full flex-1 bg-white mt-5 rounded-xl shadow-blur-xs">
                @yield('section')
            </div>
        </div>
    </section>
@endsection
