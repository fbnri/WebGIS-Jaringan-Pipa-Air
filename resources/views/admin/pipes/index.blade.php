<x-app-layout>
    <div class="p-4 md:p-6 max-w-full h-[calc(100vh-64px)] md:h-[calc(100vh-112px)] flex flex-col min-h-0">

        {{-- HEADER --}}
        <div class="flex-none flex flex-col md:flex-row md:items-center md:justify-between gap-3 relative mb-6">

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
            <form method="GET" class="flex items-center gap-2 w-full md:w-auto">

                {{-- SEARCH --}}
                <input type="text" name="search" autocomplete="off" value="{{ request('search') }}"
                    placeholder="Cari pipa..."
                    class="flex-1 px-3 py-2 rounded-xl border text-sm focus:ring-2 focus:ring-blue-500">

                {{-- FILTER BUTTON --}}
                <button type="button" id="filterToggle" title="Filter"
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
        <div class="bg-white rounded-2xl shadow-lg border overflow-hidden flex flex-col flex-1 min-h-0">

            {{-- TABLE --}}
            <div class="table-scroll flex-1 min-h-0 overflow-auto relative">
                <table class="min-w-max w-full text-sm text-left">
                    
                    {{-- HEADER --}}
                    <thead class="sticky top-0 z-20 bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="md:sticky md:left-0 z-10 bg-gray-100 px-4 py-3 min-w-[70px]">No.</th>
                            <th class="md:sticky md:left-[70px] z-10 bg-gray-100 px-4 py-3 min-w-[220px]">Nama</th>
                            <th class="md:sticky md:left-[290px] z-10 bg-gray-100 px-4 py-3 min-w-[160px] md:shadow-[4px_0_6px_-4px_rgba(0,0,0,0.15)]">Jenis</th>
                            @foreach($years as $year)
                                <th class="px-4 py-3 text-center min-w-[140px]">
                                    {{ $year }}
                                </th>
                            @endforeach
                            <th class="px-4 py-3">Panjang (m)</th>
                            <th class="md:sticky md:right-0 z-10 bg-gray-100 px-4 py-3 text-center min-w-[110px] shadow-[-4px_0_6px_-4px_rgba(0,0,0,0.15)]">Aksi</th>
                        </tr>
                    </thead>

                    {{-- BODY --}}
                    <tbody class="divide-y bg-white">
                        @forelse ($pipes as $index => $pipe)
                            <tr class="hover:bg-blue-50/50 transition">
                                <td class="md:sticky md:left-0 z-0 text-center bg-white px-4 py-3">{{ $pipes->firstItem() + $index }}</td>
                                <td class="md:sticky md:left-[70px] z-0 bg-white px-4 py-3 min-w-[220px]">
                                    <div class="flex items-center gap-2 font-semibold text-gray-800">
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

                                {{-- AKSI --}}
                                <td class="md:sticky md:right-0 z-0 bg-white px-4 py-2 text-center min-w-[110px] shadow-[-4px_0_6px_-4px_rgba(0,0,0,0.15)]">
                                    <div class="flex justify-center items-center gap-2">

                                        {{-- EDIT --}}
                                        <button
                                        class="btnEdit w-9 h-9 rounded-xl bg-amber-100 hover:bg-ambe-200 text-amber-600 flex items-center justify-center transition"
                                        title="Edit"
                                        data-id="{{ $pipe->id }}"
                                        data-name="{{ $pipe->name }}"
                                        data-type="{{ $pipe->pipe_type }}"
                                        data-planned="{{ $pipe->planned_at }}"
                                        data-installed="{{ $pipe->installed_at }}"
                                        data-length="{{ $pipe->length }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        {{-- DELETE --}}
                                        <button
                                        class="btnDelete w-9 h-9 rounded-xl bg-red-100 hover:bg-red-200 text-red-600 flex items-center justify-center transition"
                                        title="Hapus"
                                        data-id="{{ $pipe->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
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

        {{-- CARD PAGINATION --}}
        @if($pipes->hasPages())
            <div class="mt-4 bg-white rounded-2xl shadow-lg border px-4 md:px-6 py-4">
                {{ $pipes->links('vendor.pagination.tailwind') }}
            </div>
        @endif

        {{-- MODAL EDIT --}}
        <div id="editModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50 opacity-0 transition-opacity duration-200">
            <div class="bg-white w-[90%] sm:max-w-md p-6 rounded-2xl shadow-xl transform scale-95 opacity-0 transition-all duration-200 ease-out modal-content">
                <h2 class="text-lg font-semibold mb-4">Edit Data Pipa</h2>
                <input type="hidden" id="edit_id">
                <div class="space-y-3">
                    <div>
                        <label class="text-sm">Nama</label>
                        <input type="text" id="edit_name" class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="text-sm">Jenis</label>
                        <input type="text" id="edit_type" class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="text-sm">Tanggal Direncanakan</label>
                        <input type="date"
                            id="edit_planned_at"
                            class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="text-sm">Tanggal Terpasang</label>
                        <input type="date"
                            id="edit_installed_at"
                            class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="text-sm">Panjang (m)</label>
                        <input type="number" id="edit_length" class="w-full border rounded-lg p-2" readonly>
                    </div>
                </div>
                <div class="flex justify-end mt-6 space-x-2">
                    <button type="button" id="cancelEdit" class="px-4 py-2 border rounded-lg">
                        Batal
                    </button>
                    <button type="button" id="saveEdit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Simpan
                    </button>
                </div>
            </div>
        </div>

        {{-- MODAL DELETE --}}
        <div id="deleteModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50 opacity-0 transition-opacity duration-200">
            <div class="bg-white w-[90%] sm:max-w-sm p-6 rounded-2xl shadow-xl text-center transform scale-95 opacity-0 transition-all duration-200 modal-content">
                <div class="mb-4">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 text-3xl"></i>
                </div>
                <h2 class="text-lg font-semibold mb-2">Hapus Data</h2>
                <p class="text-sm text-gray-500 mb-6">
                    Yakin mau hapus data ini? Data tidak bisa dikembalikan.
                </p>
                <div class="flex gap-2">
                    <button type="button" id="cancelDelete"
                        class="flex-1 px-4 py-2 border rounded-lg">
                        Batal
                    </button>
                    <button type="button" id="confirmDelete"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.pipeTableColspan = {{ 5 + count($years) }};
    </script>
</x-app-layout>