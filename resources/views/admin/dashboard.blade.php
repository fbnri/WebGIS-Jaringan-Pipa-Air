<x-app-layout>
    <div class="p-4 md:p-6 space-y-6">

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition card-hover">
                <p class="text-sm text-gray-500">Total Pipa</p>
                <h2 id="totalPipa" class="text-2xl font-bold flex items-center gap-2 mt-1">
                    <i class="fa-solid fa-circle-nodes text-blue-500 text-lg"></i>
                    {{ $total }}
                </h2>
            </div>
            <div class="bg-green-100 rounded-2xl shadow p-5 hover:shadow-lg transition card-hover">
                <p class="text-sm text-green-700">Terpasang</p>
                <h2 id="totalTerpasang" class="text-2xl font-bold text-green-800 flex items-center gap-2 mt-1">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    {{ $totalTerpasang }}
                </h2>
            </div>
            <div class="bg-orange-100 rounded-2xl shadow p-5 hover:shadow-lg transition card-hover">
                <p class="text-sm text-orange-700">Perencanaan</p>
                <h2 id="totalPerencanaan" class="text-2xl font-bold text-orange-800 flex items-center gap-2 mt-1">
                    <i class="fa-solid fa-clock text-lg"></i>
                    {{ $totalRencana }}
                </h2>
            </div>
            <div class="bg-blue-100 rounded-2xl shadow p-5 hover:shadow-lg transition card-hover">
                <p class="text-sm text-blue-700">Total Panjang (m)</p>
                <h2 id="totalLength" class="text-2xl font-bold text-blue-800 flex items-center gap-2 mt-1">
                    <i class="fa-solid fa-ruler-horizontal text-lg"></i>
                    {{ number_format($totalLength,0,',','.') }}
                </h2>
            </div>
        </div>

        {{-- MOBILE TOOLBAR --}}
        <div class="draw-hide md:hidden flex gap-2 mb-3 sticky top-0 z-10">
            <button id="btnAddPipeMobile"
            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm flex items-center justify-center gap-2 focus:outline-none active:scale-95">
                <i class="fa-solid fa-draw-polygon"></i>
                Tambah Jalur
            </button>
        </div>

        {{-- MAP CONTAINER --}}
        <div class="relative bg-white rounded-2xl shadow-xl border overflow-hidden">
            <div class="draw-hide hidden md:flex absolute top-5 left-5 z-[1000] flex items-center gap-3">

                {{-- ADD PIPE --}}
                <button id="btnAddPipe"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow-lg flex items-center gap-2 text-sm">
                    <i class="fa-solid fa-draw-polygon"></i>
                    Tambah Jalur
                </button>

                {{-- YEAR NAVIGATOR --}}
                <div class="relative flex items-center gap-2">

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
                    <div id="yearPanel" class="absolute top-12 left-12 w-28 bg-white/80 backdrop-blur-md rounded-xl shadow-xl 
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
            </div>

            {{-- DRAW TOOLBAR --}}
            <div id="drawToolbar" class="hidden absolute bottom-10 left-1/2 -translate-x-1/2 z-[1000] bg-white/95 backdrop-blur rounded-xl shadow-xl p-2 flex gap-2 border">
                <button id="btnUndo" class="w-10 h-10 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-rotate-left"></i>
                </button>
                <button id="btnFinish" class="w-10 h-10 bg-green-600 hover:bg-green-700 text-white rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-check"></i>
                </button>
                <button id="btnCancelDraw"
                class="w-10 h-10 bg-gray-600 hover:bg-gray-700 text-white rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div id="drawInfo" class="hidden absolute top-5 left-1/2 -translate-x-1/2 bg-black/70 text-white text-xs px-4 py-2 rounded-lg z-[1000]">
                Klik peta untuk mulai menggambar | Enter: selesai | Esc: batal | Backspace: undo
            </div>

            {{-- MOBILE YEAR PICKER --}}
            <div class="draw-hide md:hidden absolute top-4 left-4 z-20">
                <button id="mobileYearBtn"
                class="bg-white rounded-xl shadow-lg px-4 py-2 text-sm font-semibold flex items-center gap-2">
                    <span id="mobileYearText">{{ $year ?? $maxYear }}</span>
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>
            </div>

            {{-- MOBILE YEAR MODAL --}}
            <div id="mobileYearModal"
            class="fixed inset-0 bg-black/40 z-[99999] hidden items-end">
                <div class="bg-white w-full rounded-t-3xl p-4 animate-slideUp">
                    <div class="w-12 h-1 bg-gray-300 rounded-full mx-auto mb-4"></div>
                    <h2 class="text-center font-semibold mb-4">
                        Pilih Tahun
                    </h2>
                    <div id="mobileYearList"
                    class="h-64 overflow-y-auto snap-y snap-mandatory text-center">

                        @for($y = $minYear; $y <= $maxYear; $y++)
                            <button
                                class="mobile-year-option block w-full py-4 text-lg snap-center
                                {{ ($year ?? $maxYear) == $y ? 'font-bold text-blue-600' : 'text-gray-500' }}"
                                data-year="{{ $y }}">
                                {{ $y }}
                            </button>
                        @endfor

                    </div>
                </div>
            </div>

            {{-- MAP --}}
            <div id="map" class="w-full h-[calc(100vh-200px)] z-0"></div>

            {{-- LAYER PANEL --}}
            <div id="layerPanelMobile" class="hidden absolute top-16 right-3 bg-white rounded-xl shadow-lg border p-3 text-sm z-30 space-y-2">
                <label class="flex items-center gap-2">
                    <input type="radio" name="basemap" value="osm">
                    OpenStreetMap
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="basemap" value="sat">
                    Satellite
                </label>
            </div>

            <div class="absolute top-4 right-4 z-20">
                <button id="layerToggle"
                class="w-10 h-10 bg-white rounded-xl shadow flex items-center justify-center transition">
                    <i class="fa-solid fa-layer-group text-gray-600"></i>
                </button>
                <div id="layerPanel"
                class="absolute right-0 mt-2 w-40 bg-white/70 backdrop-blur-md rounded-xl shadow-lg border border-white/40 p-3 opacity-0 scale-95 pointer-events-none transition-all duration-200">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="radio" name="basemap" value="osm">
                        OpenStreetMap
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="radio" name="basemap" value="sat">
                        Satelit
                    </label>
                </div>
            </div>

            {{-- LEGEND --}}
            <div id="legendBox" class="draw-hide hidden md:block absolute bottom-4 left-4 z-10 bg-white/95 backdrop-blur p-4 rounded-xl shadow text-sm border">
                <p class="font-semibold mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-layer-group text-gray-600"></i>
                    Legenda
                </p>
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-1 bg-blue-600 rounded flex-shrink-0"></div>
                        <span>Terpasang</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <div class="w-6 h-1 bg-cyan-300 rounded flex-shrink-0"></div>
                        <span>Perencanaan</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <div class="w-6 flex justify-center flex-shrink-0">
                            <i class="fa-solid fa-location-dot text-red-500"></i>
                        </div>
                        <span>Pelanggan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    <input type="date" id="edit_planned_at" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="text-sm">Tanggal Terpasang</label>
                    <input type="date" id="edit_installed_at" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="text-sm">Panjang (m)</label>
                    <input type="number" id="edit_length" class="w-full border rounded-lg p-2" readonly>
                </div>
            </div>
            <div class="flex justify-between mt-6">
                <button id="deletePipe"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                    Hapus
                </button>
                <div class="space-x-2">
                    <button id="cancelBtn"
                        class="px-4 py-2 border rounded-lg">
                        Batal
                    </button>
                    <button id="saveEdit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DELETE --}}
    <div id="deleteModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-[99999] opacity-0 transition-opacity duration-200">
        <div class="bg-white w-[90%] sm:max-w-sm p-6 rounded-2xl shadow-xl text-center transform scale-95 opacity-0 transition-all duration-200 ease-out modal-content">
            <div class="mb-4">
                <i class="fa-solid fa-triangle-exclamation text-red-500 text-3xl"></i>
            </div>
            <h2 class="text-lg font-semibold mb-2">Hapus Data</h2>
            <p class="text-sm text-gray-500 mb-6">
                Yakin mau hapus pipa ini? Data tidak bisa dikembalikan.
            </p>
            <div class="flex gap-2">
                <button id="cancelDelete"
                    class="flex-1 px-4 py-2 border rounded-lg">
                    Batal
                </button>
                <button id="confirmDelete"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL CREATE --}}
    <div id="createModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-[99999] opacity-0 transition-opacity duration-200">
        <div class="bg-white w-[90%] sm:max-w-md p-6 rounded-2xl shadow-xl transform scale-95 opacity-0 transition-all duration-200 ease-out modal-content">
            <h2 class="text-lg font-semibold mb-4">Tambah Pipa Baru</h2>
            <div class="space-y-3">
                <div>
                    <label class="text-sm">Nama Pipa</label>
                    <input type="text" id="create_name" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="text-sm">Jenis Pipa</label>
                    <input type="text" id="create_type" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="text-sm">Tanggal Direncanakan</label>
                    <input type="date" id="planned_at" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="text-sm">Tanggal Terpasang (opsional)</label>
                    <input type="date" id="installed_at" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="text-sm">Panjang (m)</label>
                    <input type="number" id="create_length"
                    readonly
                    class="w-full border rounded-lg p-2 bg-gray-100">
                </div>
            </div>
            <div class="flex justify-end mt-6 space-x-2">
                <button id="cancelCreate"
                    class="px-4 py-2 border rounded-lg">
                    Batal
                </button>
                <button id="saveCreate"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Simpan
                </button>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    @endpush

    <script>
        window.pipesData = @json($pipes);
        window.customersData = @json($customers);
        window.currentYear = @json($year ?? $maxYear);
        window.minYear = @json($minYear);
        window.maxYear = @json($maxYear);
    </script>

    @vite('resources/js/modules/admin/adminDashboard.js')
</x-app-layout>