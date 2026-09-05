<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Masuk | NEKAT TEFA')</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="flex min-h-screen flex-col justify-center bg-[var(--color-neutral-50)] px-4 py-10">
            <div class="mx-auto mb-6 text-center">
                <a href="{{ route('home') }}" class="font-display text-xl font-extrabold tracking-tight text-[var(--color-primary-600)]">
                    NEKAT <span class="text-[var(--color-accent-600)]">TEFA</span>
                </a>
                <p class="mt-2 text-xs font-medium uppercase tracking-[0.18em] text-[var(--color-neutral-500)]">Teaching Factory Katapang</p>
            </div>

            <div class="mx-auto w-full max-w-md overflow-hidden rounded-2xl border border-[var(--color-neutral-200)] bg-white p-6 shadow-[var(--shadow-md)] sm:p-8">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
