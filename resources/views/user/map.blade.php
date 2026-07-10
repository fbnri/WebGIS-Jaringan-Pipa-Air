@extends('layouts.user-panel')
    @section('content')
    @php
        $pipes = $pipes ?? [];
    @endphp

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    @endpush

    <div class="p-4 md:p-6 space-y-6">

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            {{-- TOTAL --}}
            <div class="bg-white rounded-2xl shadow p-4 hover:shadow-lg transition card-hover w-full">
                <p class="text-sm text-gray-500">Total Pipa</p>
                <h2 class="text-2xl font-bold flex items-center gap-2 mt-1">
                    <i class="fa-solid fa-circle-nodes text-blue-500 text-lg"></i>
                    {{ $totalPipa }}
                </h2>
            </div>

            {{-- TERPASANG --}}
            <div class="bg-green-100 rounded-2xl shadow p-4 hover:shadow-lg transition card-hover w-full">
                <p class="text-sm text-green-700">Terpasang</p>
                <h2 class="text-2xl font-bold text-green-800 flex items-center gap-2 mt-1">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    {{ $totalTerpasang }}
                </h2>
                <div class="mt-2 bg-white/40 rounded-full h-1.5">
                    <div class="bg-green-600 h-1.5 rounded-full"
                        style="width: {{ $totalPipa ? ($totalTerpasang / $totalPipa * 100) : 0 }}%">
                    </div>
                </div>
            </div>

            {{-- PERENCANAAN --}}
            <div class="bg-orange-100 rounded-2xl shadow p-4 hover:shadow-lg transition card-hover w-full">
                <p class="text-sm text-orange-700">Perencanaan</p>
                <h2 class="text-2xl font-bold text-orange-800 flex items-center gap-2 mt-1">
                    <i class="fa-solid fa-clock text-lg"></i>
                    {{ $totalRencana }}
                </h2>
                <div class="mt-2 bg-white/40 rounded-full h-1.5">
                    <div class="bg-orange-500 h-1.5 rounded-full"
                        style="width: {{ $totalPipa ? ($totalRencana / $totalPipa * 100) : 0 }}%">
                    </div>
                </div>
            </div>
        </div>

        {{-- MAP --}}
        <div class="relative bg-white rounded-2xl shadow-xl border overflow-hidden">
            {{-- YEAR NAVIGATOR --}}
            <div class="absolute top-4 left-4 z-20 flex items-center gap-2">

                {{-- PREV --}}
                <button id="prevYear"
                class="w-10 h-10 bg-white rounded-xl shadow flex items-center justify-center hover:bg-gray-100 transition">
                    <i class="fa-solid fa-chevron-left text-sm text-gray-600"></i>
                </button>

                {{-- YEAR --}}
                <button id="yearDisplay"
                class="h-10 px-5 bg-white rounded-xl shadow text-sm font-semibold hover:bg-gray-100 transition">
                    {{ $year ?? $maxYear }}
                </button>

                {{-- NEXT --}}
                <button id="nextYear"
                class="w-10 h-10 bg-white rounded-xl shadow flex items-center justify-center hover:bg-gray-100 transition">
                    <i class="fa-solid fa-chevron-right text-sm text-gray-600"></i>
                </button>

                {{-- PANEL --}}
                <div id="yearPanel"
                class="absolute top-12 left-12 w-28 bg-white/80 backdrop-blur-md rounded-xl shadow-xl
                border border-white/40 overflow-hidden opacity-0 scale-95 pointer-events-none transition-all duration-200 z-[99999]">
                    <div class="max-h-56 overflow-y-auto py-1">
                        @for($y = $minYear; $y <= $maxYear; $y++)
                            <button
                            class="year-option w-full text-center px-4 py-2 text-sm hover:bg-blue-50 transition
                            {{ ($year ?? $maxYear) == $y ? 'bg-blue-100 font-semibold text-blue-700' : '' }}"
                            data-year="{{ $y }}">
                                {{ $y }}
                            </button>
                        @endfor
                    </div>
                </div>
            </div>
            <div id="map" class="w-full min-h-[350px] md:min-h-[400px] h-[calc(100vh-290px)] z-0"></div>

            {{-- LAYER BUTTON --}}
            <div class="absolute top-4 right-4 z-20">
                <button id="layerToggle"
                    class="w-10 h-10 bg-white rounded-xl shadow flex items-center justify-center transition duration-200">
                    <i class="fa-solid fa-layer-group text-gray-600"></i>
                </button>

                {{-- PANEL --}}
                <div id="layerPanel"
                class="absolute right-0 mt-2 w-40 bg-white/70 backdrop-blur-md rounded-xl shadow-lg border border-white/40 p-3 opacity-0 scale-95 pointer-events-none transition-all duration-200">
                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                        <input type="radio" name="basemap" value="osm" checked>
                        OpenStreetMap
                    </label>
                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                        <input type="radio" name="basemap" value="sat">
                        Satelit
                    </label>
                </div>
            </div>

            {{-- LEGEND --}}
            <div class="hidden md:block absolute bottom-4 left-4 z-[1000] bg-white/95 backdrop-blur p-4 rounded-xl shadow text-sm border">
                <p class="font-semibold mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-layer-group text-gray-600"></i>
                    Legenda
                </p>
                <div id="legendContent" class="space-y-2"></div>
            </div>
        </div>
    </div>

    <script>
        window.pipesData = @json($pipes);
        window.customersData = @json($customers);
        window.currentYear = @json($year ?? $maxYear);
        window.minYear = @json($minYear);
        window.maxYear = @json($maxYear);
    </script>

    @push('scripts')
        @vite('resources/js/modules/user/userMap.js')
    @endpush
@endsection