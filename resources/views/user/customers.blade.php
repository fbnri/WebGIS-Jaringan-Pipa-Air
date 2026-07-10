@extends('layouts.user-panel')

@section('content')
<div class="p-4 md:p-6 max-w-full h-[calc(100vh-64px)] md:h-[calc(100vh-112px)] flex flex-col min-h-0">

    {{-- HEADER --}}
    <div class="flex-none flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-gray-800">
                Data Pelanggan
            </h1>
            <p class="text-sm text-gray-500">
                Informasi pelanggan jaringan PDAM
            </p>
        </div>

        {{-- SEARCH --}}
        <form method="GET"
        class="flex items-center gap-2 w-full md:w-auto">
            <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari pelanggan..."
            autocomplete="off"
            class="flex-1 px-3 py-2 rounded-xl border text-sm focus:ring-2 focus:ring-blue-500">
            <button
            type="submit"
            class="bg-blue-600 text-white px-3 py-2 rounded-xl text-sm">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-lg border overflow-hidden flex flex-col flex-1 min-h-0">
        <div class="table-scroll flex-1 min-h-0 overflow-auto">
            <table class="min-w-max w-full text-sm text-left">
                <thead class="sticky top-0 bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 min-w-[70px]">
                            No
                        </th>
                        <th class="px-4 py-3 min-w-[220px]">
                            Nama
                        </th>
                        <th class="px-4 py-3 min-w-[320px]">
                            Alamat
                        </th>
                        <th class="px-4 py-3 min-w-[180px]">
                            Mulai Berlangganan
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-blue-50/50">
                            <td class="px-4 py-3 text-center">
                                {{ $customers->firstItem() + $loop->index }}
                            </td>
                            <td class="px-4 py-3 font-semibold">
                                {{ $customer->name }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $customer->address ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $customer->subscribed_at
                                ? \Carbon\Carbon::parse($customer->subscribed_at)->format('d M Y')
                                : '-'
                                }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4"
                            class="text-center py-10 text-gray-400">
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
        <div class="mt-4 bg-white rounded-2xl shadow border px-4 py-4">
            {{ $customers->links() }}
        </div>
    @endif
</div>
@endsection