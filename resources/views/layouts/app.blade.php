<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'NEKAT TEFA | Teaching Factory Katapang')</title>

        <!-- Fonts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="min-h-screen">
            <x-navbar />
            <main>
                {{ $slot ?? '' }}
                @yield('content')
            </main>
            <x-footer />
        </div>
    </body>
</html>
