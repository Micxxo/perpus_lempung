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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<style>
    [x-cloak] {
        display: none !important;
    }

    .custom-scrollbar {
        width: 100%;
        height: 300px;
        overflow-y: scroll;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #E5E5E5;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #45a049;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background-color: #f1f1f1;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-corner {
        background-color: #f1f1f1;
    }
</style>

<body class="font-instrument-sans h-screen">
    <main class="h-screen max-w-screen-2xl mx-auto bg-background">
        @yield('content')
    </main>
</body>

</html>
