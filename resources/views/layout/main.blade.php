<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Perpustakaan Lempung')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- font  --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body class="font-instrument-sans h-screen">
    <main class="h-screen max-w-screen-2xl mx-auto bg-background">
        @yield('content')
    </main>
</body>

</html>
