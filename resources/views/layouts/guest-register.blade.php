<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#f8f9fa] dark:bg-gray-950">
        <div class="min-h-screen flex flex-col justify-center items-center py-10 px-4 sm:px-6">
            <div class="shrink-0 flex justify-center mb-6 w-1/2 min-w-0 mx-auto">
                <a href="{{ route('login') }}" wire:navigate class="inline-block" aria-label="{{ config('app.name') }}">
                    <x-application-logo class="w-12 h-12 sm:w-16 sm:h-16 fill-current text-blue-600 dark:text-blue-400" />
                </a>
            </div>

            <div class="w-1/2 min-w-0 mx-auto bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm px-6 py-8 sm:px-8 sm:py-10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
