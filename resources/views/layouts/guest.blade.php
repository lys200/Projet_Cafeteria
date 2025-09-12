<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cafet CHC') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-accent/5">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Logo -->
        <div class="w-24 h-24 rounded-full bg-primary flex items-center justify-center shadow-lg mt-2 mb-3">
            <img src="{{ asset('images/default3.png') }}" alt="logo cafet" class="h-16"> <br>
        </div>
        <h1 class="text-2xl text-primary font-bold">Cafeteria CHCL</h1>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white/90 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>

        <div class="mt-6 text-center text-primary text-sm">
            &copy; {{ date('Y') }} Cafet-CHCL-2025-CNS Tous droits réservés
        </div>
    </div>
</body>
</html>