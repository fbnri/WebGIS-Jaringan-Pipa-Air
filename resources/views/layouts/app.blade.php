<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">   

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- Font Awesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        {{-- Scripts --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased overflow-x-hidden">
        @include('layouts.navigation')
        {{-- @if(auth()->check())
            <div class="fixed bottom-4 right-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg shadow">
                        Logout
                    </button>
                </form>
            </div>
        @endif --}}
        @stack('scripts')
    </body>
</html>