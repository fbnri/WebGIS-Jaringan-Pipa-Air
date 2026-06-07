@extends('layouts.user-panel')
@section('content')
    <div class="p-4 md:p-6 space-y-6 max-w-full overflow-visible">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 relative">

            {{-- TITLE --}}
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800">
                    Data Pipa
                </h1>
                <p class="text-sm text-gray-500">
                    Daftar seluruh data jaringan pipa
                </p>
            </div>

            {{-- SEARCH + FILTER --}}
            <form method="GET" class="flex items-center gap-2">

                {{-- SEARCH --}}
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari pipa..."
                    class="px-3 py-2 rounded-xl border text-sm focus:ring-2 focus:ring-blue-500"
                    autocomplete="off">

                {{-- FILTER BUTTON --}}
                <button type="button" id="filterToggle"
                    class="w-10 h-10 bg-white rounded-xl shadow flex items-center justify-center hover:bg-gray-100">
                    <i class="fa-solid fa-filter text-gray-600"></i>
                </button>

                {{-- SUBMIT SEARCH --}}
                <button type="submit"
                    class="bg-blue-600 text-white px-3 py-2 rounded-xl text-sm">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            {{-- FILTER POPUP --}}
            <div id="filterPanel"
            class="absolute top-12 right-0 w-64 bg-white rounded-xl shadow-lg border p-4 opacity-0 scale-95 
            pointer-events-none transition-all duration-200 z-[999]">
                <form method="GET" class="space-y-3">

                    {{-- BAWA SEARCH --}}
                    <input type="hidden" name="search" value="{{ request('search') }}">

                    {{-- JENIS --}}
                    <div>
                        <label class="text-xs text-gray-500">Jenis Pipa</label>
                        <div class="mt-1 space-y-1 max-h-32 overflow-y-auto">
                            @foreach($pipeTypes as $type)
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="checkbox" name="type[]" value="{{ $type }}"
                                        {{ in_array($type, (array)request('type')) ? 'checked' : '' }}>
                                    {{ $type }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- BUTTON --}}
                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white py-1 rounded text-xs">
                            Terapkan
                        </button>
                        <a href="{{ url()->current() }}"
                            class="flex-1 bg-gray-200 text-center py-1 rounded text-xs">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- CARD TABLE --}}
        <div class="bg-white rounded-2xl shadow-lg border">

            {{-- TABLE --}}
            <div class="overflow-x-auto relative">
                <table class="min-w-max w-full text-sm text-left">
                    
                    {{-- HEADER --}}
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="md:sticky md:left-0 z-10 bg-gray-100 px-4 py-3 min-w-[70px]">No</th>
                            <th class="md:sticky md:left-[70px] z-10 bg-gray-100 px-4 py-3 min-w-[220px]">Nama</th>
                            <th class="md:sticky md:left-[290px] z-10 bg-gray-100 px-4 py-3 min-w-[160px] shadow-[4px_0_6px_-4px_rgba(0,0,0,0.15)]">Jenis</th>
                            @foreach($years as $year)
                                <th class="px-4 py-3 text-center min-w-[140px]">
                                    {{ $year }}
                                </th>
                            @endforeach
                            <th class="px-4 py-3">Panjang (m)</th>
                        </tr>
                    </thead>

                    {{-- BODY --}}
                    <tbody class="divide-y">
                        @forelse ($pipes as $index => $pipe)
                            <tr class="hover:bg-blue-50/50 transition">
                                <td class="md:sticky md:left-0 z-0 bg-white px-4 py-3">{{ $index + 1 }}</td>
                                <td class="md:sticky md:left-[70px] z-0 bg-white px-4 py-3 min-w-[220px]">
                                    <div class="flex items-center gap-2 font-semibold text-gray-800">
                                        @if($pipe->installed_at)
                                            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                        @else
                                            <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                                        @endif

                                        {{ $pipe->name }}
                                    </div>
                                </td>
                                <td class="md:sticky md:left-[290px] z-0 bg-white px-4 py-3 min-w-[160px] shadow-[4px_0_6px_-4px_rgba(0,0,0,0.15)]">
                                    {{ $pipe->pipe_type }}
                                </td>

                                @foreach($years as $year)
                                    @php
                                        $plannedYear = $pipe->planned_at
                                        ? \Carbon\Carbon::parse($pipe->planned_at)->format('Y') : null;

                                        $installedYear = $pipe->installed_at
                                        ? \Carbon\Carbon::parse($pipe->installed_at)->format('Y') : null;
                                    @endphp
                                    <td class="px-4 py-3 text-center">

                                        {{-- N/A --}}
                                        @if($plannedYear && $year < $plannedYear)
                                            <span class="inline-flex items-center justify-center
                                                px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                                N/A
                                            </span>

                                        {{-- TERPASANG --}}
                                        @elseif($installedYear && $year >= $installedYear)
                                            <span class="inline-flex items-center justify-center
                                                px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                Terpasang
                                            </span>

                                        {{-- PERENCANAAN --}}
                                        @else
                                            <span class="inline-flex items-center justify-center
                                                px-3 py-1 rounded-full text-xs font-medium
                                                bg-orange-100 text-orange-700">
                                                Perencanaan
                                            </span>
                                        @endif
                                    </td>
                                @endforeach

                                {{-- PANJANG --}}
                                <td class="px-4 py-3 font-medium text-gray-700">
                                    {{ number_format($pipe->length,0,',','.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 5 + count($years) }}" class="text-center py-6 text-gray-400">
                                    Data pipa belum tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection