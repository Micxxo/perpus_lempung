<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perpustakaan Lempung</title>
    @vite('resources/css/app.css')
</head>

<body>
    <main class="h-screen max-w-screen-2xl mx-auto bg-background">
        <section class="px-10 py-3">
            @include('layout.navbar')
            @yield('section')
        </section>
    </main>
</body>

</html>
