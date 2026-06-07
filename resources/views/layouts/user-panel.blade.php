<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WebGIS</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    {{-- Font Awesome --}}
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')
</head>

<body class="font-sans antialiased overflow-x-hidden bg-gray-100">
<div x-data="sidebar" class="flex w-full overflow-x-hidden">

    {{-- OVERLAY MOBILE --}}
    <div
    x-show="sidebarOpen"
    @click="closeSidebar()"
    class="fixed inset-0 bg-black/40 z-30 md:hidden">
    </div>

    {{-- SIDEBAR --}}
    <aside
    :class="[
        sidebarOpen ? 'translate-x-0' : '-translate-x-full',
        sidebarCollapsed ? 'md:w-20 w-64' : 'md:w-64 w-64'
    ]"
    class="h-screen bg-gray-900 text-white fixed md:translate-x-0 transform transition-all duration-200 ease-out flex flex-col z-40">

        {{-- LOGO --}}
        <div :class="sidebarCollapsed
        ? 'md:flex md:justify-center md:items-center md:px-0 md:py-4 flex justify-center items-center px-0 py-4'
        : 'flex items-center px-5 py-5'"
        class="border-b border-gray-700">
            <h1
            :class="sidebarCollapsed
            ? 'md:flex md:items-center md:justify-center md:w-full flex items-center justify-center w-full'
            : 'flex items-center gap-2'"
            class="text-md font-bold">
                <i :class="sidebarCollapsed ? 'md:text-2xl md:translate-x-[3px] text-lg' : 'text-lg'"
                class="fa-solid fa-map-location-dot transition-all duration-300">
                </i>
                <span :class="sidebarCollapsed
                ? 'md:opacity-0 md:max-w-0 md:overflow-hidden opacity-100 max-w-xs ml-2'
                : 'opacity-100 max-w-xs ml-2'"
                class="transition-all duration-300 whitespace-nowrap inline-block">
                    WebGIS Jaringan Pipa
                </span>
            </h1>
        </div>

        {{-- MENU --}}
        <nav class="p-4 space-y-2 text-sm">

            {{-- DASHBOARD --}}
            <a href="{{ route('home') }}"
            class="group flex items-center gap-3 px-3 py-2 rounded-lg
            {{ request()->routeIs('home') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 text-gray-300' }}">
                <i class="fa-solid fa-chart-line w-5 text-center"></i>
                <span
                :class="sidebarCollapsed
                ? 'md:hidden'
                : 'inline-block'">
                    Dashboard
                </span>
            </a>

            {{-- DATA PIPA --}}
            <a href="{{ route('user.pipes') }}"
            class="group flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('user.pipes')
            ? 'bg-gray-800 text-white' 
            : 'hover:bg-gray-800 text-gray-300' }}">
                <i class="fa-solid fa-database w-5 text-center"></i>
                <span
                :class="sidebarCollapsed
                ? 'md:hidden'
                : 'inline-block'">
                    Data Pipa
                </span>
            </a>
        </nav>

        {{-- LOGIN ADMIN --}}
        <div class="mt-auto p-4">
            <a href="{{ route('login') }}"
            class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span
                :class="sidebarCollapsed
                ? 'md:hidden'
                : 'inline-block'">
                    Login Admin
                </span>
            </a>
        </div>
    </aside>

    {{-- CONTENT --}}
    <div
    :class="sidebarCollapsed ? 'md:ml-20' : 'md:ml-64'"
    class="flex-1 min-h-[100dvh] bg-gray-100 transition-all duration-300 w-full overflow-x-hidden">

        {{-- TOPBAR --}}
        <header class="bg-white shadow h-16 flex items-center px-6">

            {{-- MOBILE --}}
            <button
            @click="toggleSidebar()"
            class="md:hidden text-gray-600">
                <i class="fa-solid fa-bars"></i>
            </button>

            {{-- DESKTOP --}}
            <button
            @click="toggleCollapse()"
            class="hidden md:block text-gray-600">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="flex-1 flex justify-end">
                <h1 class="font-semibold text-gray-700">
                    Sistem Monitoring Pipa
                </h1>
            </div>
        </header>

        {{-- PAGE --}}
        <main class="p-6">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')

</body>
</html>