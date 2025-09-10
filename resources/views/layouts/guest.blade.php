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
<body class="font-sans text-gray-900 antialiased bg-light">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Logo -->
        <div class="w-24 h-24 rounded-full bg-primary-500 flex items-center justify-center shadow-lg mb-6">
            <svg class="w-12 h-12 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 15.546C20.477 15.546 19.954 15.697 19.5 16C18.704 16.606 17.704 16.606 16.908 16C16.112 16.606 15.112 16.606 14.316 16C13.52 16.606 12.52 16.606 11.724 16C10.928 16.606 9.928 16.606 9.132 16C8.336 16.606 7.336 16.606 6.54 16C5.744 16.606 4.744 16.606 3.948 16C3.494 15.697 2.971 15.546 2.448 15.546H3V5C3 3.895 3.895 3 5 3H19C20.105 3 21 3.895 21 5V15.546H21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 11V7M12 11C11.204 11 10.408 10.394 9.612 10.394C8.816 10.394 8.02 11 7.224 11C6.428 11 5.632 10.394 4.836 10.394C4.04 10.394 3.244 11 2.448 11M12 11C12.796 11 13.592 10.394 14.388 10.394C15.184 10.394 15.98 11 16.776 11C17.572 11 18.368 10.394 19.164 10.394C19.96 10.394 20.756 11 21.552 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M21 15.546C20.477 15.546 19.954 15.697 19.5 16C18.704 16.606 17.704 16.606 16.908 16C16.112 16.606 15.112 16.606 14.316 16C13.52 16.606 12.52 16.606 11.724 16C10.928 16.606 9.928 16.606 9.132 16C8.336 16.606 7.336 16.606 6.54 16C5.744 16.606 4.744 16.606 3.948 16C3.494 15.697 2.971 15.546 2.448 15.546H3V19C3 20.105 3.895 21 5 21H19C20.105 21 21 20.105 21 19V15.546Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-light-card shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>

        <div class="mt-6 text-center text-gray-600 text-sm">
            &copy; {{ date('Y') }} Cafet CHC - Tous droits réservés
        </div>
    </div>
</body>
</html>