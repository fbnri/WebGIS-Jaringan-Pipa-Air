<x-app-layout>
    <div class="p-4 md:p-6 max-w-full h-[calc(100vh-64px)] md:h-[calc(100vh-112px)] flex flex-col min-h-0">

        {{-- HEADER --}}
        <div class="flex-none flex flex-col md:flex-row md:items-center md:justify-between gap-3 relative mb-6">

            {{-- TITLE --}}
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800">
                    Data Pelanggan
                </h1>
                <p class="text-sm text-gray-500">
                    Manajemen data pelanggan PDAM
                </p>
            </div>

            {{-- SEARCH + FILTER --}}
            <form method="GET" class="flex items-center gap-2 w-full md:w-auto">

                {{-- SEARCH --}}
                <input 
                    type="text"
                    name="search"
                    autocomplete="off"
                    value="{{ request('search') }}"
                    placeholder="Cari pelanggan..."
                    class="flex-1 px-3 py-2 rounded-xl border text-sm focus:ring-2 focus:ring-blue-500">

                {{-- SEARCH BUTTON --}}
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-3 py-2 rounded-xl text-sm">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow-lg border overflow-hidden flex flex-col flex-1 min-h-0">
            <div class="table-scroll flex-1 min-h-0 overflow-auto relative">
                <table class="min-w-max w-full text-sm text-left">
                    <thead class="sticky top-0 z-20 bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 min-w-[70px] text-left">
                                No.
                            </th>
                            <th class="px-4 py-3 min-w-[220px] text-left">
                                Nama
                            </th>
                            <th class="px-4 py-3 min-w-[320px] whitespace-nowrap">
                                Alamat
                            </th>
                            <th class="px-4 py-3 min-w-[180px] text-center whitespace-nowrap">
                                Mengajukan Sambungan
                            </th>
                            <th class="px-4 py-3 min-w-[110px] text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y bg-white">
                        @forelse($customers as $customer)
                            <tr class="hover:bg-blue-50/50 transition">
                                <td class="px-4 py-3 min-w-[70px] text-center text-gray-500">
                                    {{ $customers->firstItem() + $loop->index }}
                                </td>
                                <td class="px-4 py-3 min-w-[220px] font-semibold text-gray-800">
                                    <div class="font-semibold text-gray-800">
                                        {{ $customer->name }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 min-w-[320px] text-gray-600">
                                    {{ $customer->address ?? '-' }}
                                </td>
                                <td class="px-4 py-3 min-w-[180px] text-gray-600 whitespace-nowrap">
                                    {{ $customer->subscribed_at 
                                    ? \Carbon\Carbon::parse($customer->subscribed_at)->format('d M Y')
                                    : '-'
                                    }}
                                </td>
                                <td class="px-4 py-3 min-w-[110px]">
                                    <div class="flex justify-center gap-2">
                                        <button
                                        type="button"
                                        title="Edit"
                                        data-id="{{ $customer->id }}"
                                        data-name="{{ $customer->name }}"
                                        data-address="{{ $customer->address }}"
                                        data-subscribed="{{ $customer->subscribed_at }}"
                                        data-latitude="{{ $customer->latitude }}"
                                        data-longitude="{{ $customer->longitude }}"
                                        class="editCustomerBtn w-9 h-9 rounded-xl bg-amber-100 hover:bg-amber-200 text-amber-600 flex items-center justify-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button
                                        type="button"
                                        title="Hapus"
                                        data-id="{{ $customer->id }}"
                                        class="deleteCustomerBtn w-9 h-9 rounded-xl bg-red-100 hover:bg-red-200 text-red-600 flex items-center justify-center">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10 text-gray-400">
                                    Belum ada data pelanggan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        @if($customers->hasPages())
            <div class="mt-4 bg-white rounded-2xl shadow-lg border px-4 md:px-6 py-4">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

    {{-- EDIT CUSTOMER MODAL --}}
    <div id="editCustomerModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-[99999] opacity-0 transition-all duration-200">
        <div class="modal-content bg-white w-[90%] sm:max-w-md p-6 rounded-2xl shadow-xl scale-95 opacity-0 transition-all duration-200">
            <h2 class="text-lg font-semibold mb-4">
                Edit Pelanggan
            </h2>
            <form id="editCustomerForm" class="space-y-4">
                <input type="hidden" id="editCustomerId">
                <div>
                    <label class="text-sm">
                        Nama Pelanggan
                    </label>
                    <input type="text" id="editCustomerName" autocomplete="off" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="text-sm">
                        Alamat
                    </label>
                    <textarea id="editCustomerAddress" rows="3" class="w-full border rounded-lg p-2 resize-none"></textarea>
                </div>
                <div>
                    <label class="text-sm">
                        Mengajukan Sambungan
                    </label>
                    <input type="date" id="editCustomerSubscribedAt" class="w-full border rounded-lg p-2">
                </div>
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-2">
                    <button type="button" id="closeEditCustomer" class="px-4 py-2 border rounded-lg">
                        Batal
                    </button>
                    <button id="saveEditCustomer" type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- DELETE CUSTOMER MODAL --}}
    <div id="deleteCustomerModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-[99999] opacity-0 transition-all duration-200">
        <div class="modal-content bg-white w-[90%] sm:max-w-sm p-6 rounded-2xl shadow-xl text-center scale-95 opacity-0 transition-all duration-200">
            <div class="mb-4">
                <i class="fa-solid fa-triangle-exclamation text-red-500 text-3xl"></i>
            </div>
            <h2 class="text-lg font-semibold mb-2">
                Hapus Pelanggan
            </h2>
            <p class="text-sm text-gray-500 mb-6">
                Yakin ingin menghapus pelanggan ini?
            </p>
            <div class="flex gap-2">
                <button id="cancelDeleteCustomer" class="flex-1 px-4 py-2 border rounded-lg">
                    Batal
                </button>
                <form id="deleteCustomerForm" method="POST" class="flex-1">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    @vite('resources/js/modules/admin/adminCustomer.js')
</x-app-layout>