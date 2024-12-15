@extends('layout.main')
@section('content')
    <section class="px-5 md:px-14 py-3">
        <div class="relative w-full">
            @include('layout.navbar')
        </div>
        @yield('section')
    </section>
@endsection
