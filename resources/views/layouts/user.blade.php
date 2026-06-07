    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>WebGIS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- Font Awesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
    <body class="bg-gray-100">

        {{-- NAVBAR --}}
        <header class="bg-white shadow">
            <div class="flex items-center justify-between px-4 md:px-6 h-16">

                {{-- LEFT (LOGO) --}}
                <div class="flex items-center gap-4 text-gray-700 font-semibold text-sm md:text-base">
                    <i class="fa-solid fa-map-location-dot text-blue-600 text-2xl md:text-3xl"></i>
                    <span class="text-lg">WebGIS Monitoring Pipa</span>
                </div>

                {{-- RIGHT (DESKTOP) --}}
                <div class="hidden md:flex items-center">
                    <a href="{{ route('login') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                        Login Admin
                    </a>
                </div>

                {{-- HAMBURGER (MOBILE) --}}
                <button id="menuBtn" class="md:hidden text-gray-600 text-xl">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            {{-- MOBILE MENU --}}
            <div id="mobileMenu"
            class="absolute top-16 left-0 w-full bg-white/90 shadow-xl overflow-hidden max-h-0 opacity-0 transition-all duration-300 md:hidden z-50">
                <div class="px-4 py-3">
                    <a href="{{ route('login') }}"
                    class="block bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded-lg text-sm">
                        Login Admin
                    </a>
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="p-6">
            @yield('content')
        </main>

        @stack('scripts')
    </body>
    </html>