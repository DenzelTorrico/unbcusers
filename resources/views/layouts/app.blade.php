<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white h-full">
            <div class="p-4">
                <!-- Logo o título del sidebar -->
                <h1 class="text-lg font-bold">{{ config('app.name', 'Laravel usuarios') }}</h1>
                <!-- Nombre de la sesión -->
                <div class="text-lg text-white">
                    <h1> Bienvenido, {{ auth()->user()->name }}</h1>
                    </div>
            </div>
        </div>
        
        <!-- Contenido principal -->
        <div class="flex-1 ml-3">
            {{ $slot }}
        </div>
    </div>

    <!-- Scripts -->
    @livewireScripts
</body>
</html>
