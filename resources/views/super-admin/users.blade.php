<x-app-layout>
    <div
        id="adminPageData"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}"
        hidden>
    </div>

    <div class="p-4 md:p-6 max-w-full h-[calc(100vh-64px)] md:h-[calc(100vh-112px)] flex flex-col min-h-0">

        {{-- HEADER --}}
        <div class="flex-none flex flex-col md:flex-row md:items-center md:justify-between gap-3 relative mb-6">

            {{-- TITLE --}}
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800">
                    Kelola Admin
                </h1>
                <p class="text-sm text-gray-500">
                    Manajemen akun administrator
                </p>
            </div>

            {{-- SEARCH + BUTTON --}}
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <form method="GET" class="flex items-center gap-2 w-full">
                    <input type="text" name="search" autocomplete="off" value="{{ request('search') }}" placeholder="Cari nama atau email admin..."
                    class="flex-1 px-3 py-2 rounded-xl border text-sm focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded-xl text-sm">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
                <button id="openCreateAdmin" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow text-sm whitespace-nowrap">
                    <i class="fa-solid fa-plus mr-1"></i>
                    Tambah Admin
                </button>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg border overflow-hidden flex flex-col flex-1 min-h-0">
            <div class="table-scroll flex-1 min-h-0 overflow-auto relative">
                <table class="min-w-max w-full text-sm text-left">

                    {{-- HEADER TABLE --}}
                    <thead class="sticky top-0 z-20 bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 min-w-[70px] text-left">
                                No.
                            </th>
                            <th class="px-4 py-3 min-w-[220px] text-left">
                                Nama
                            </th>
                            <th class="px-4 py-3 min-w-[260px] text-left">
                                Email
                            </th>
                            <th class="px-4 py-3 min-w-[140px] text-left">
                                Status
                            </th>
                            <th class="px-4 py-3 min-w-[220px] text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y bg-white">
                        @foreach($admins as $admin)
                            <tr class="hover:bg-blue-50/50 transition">
                                <td class="px-4 py-3 min-w-[70px] text-center text-gray-500">
                                    {{ $admins->firstItem() + $loop->index }}
                                </td>
                                <td class="px-4 py-3 min-w-[220px] font-semibold text-gray-800">
                                    {{ $admin->name }}
                                </td>
                                <td class="px-4 py-3 min-w-[260px] text-gray-600">
                                    {{ $admin->email }}
                                </td>
                                <td class="px-4 py-3 min-w-[140px]">
                                    @if($admin->is_active)
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 min-w-[220px]">
                                    <div class="flex justify-center gap-2">

                                        {{-- RESET PASSWORD --}}
                                        <form method="POST" action="{{ route('super.users.reset',$admin->id) }}" class="resetAdminForm">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" title="Reset Password"
                                            class="resetAdminBtn bg-blue-100 hover:bg-blue-200 text-blue-600 w-9 h-9 rounded-xl flex items-center justify-center">
                                                <i class="fa-solid fa-key"></i>
                                            </button>
                                        </form>

                                        {{-- DISABLE / ENABLE --}}
                                        <form method="POST" action="{{ route('super.users.toggle',$admin->id) }}" class="toggleAdminForm">
                                            @csrf
                                            @method('PUT')

                                            <button
                                            type="submit"
                                            title="{{ $admin->is_active ? 'Disable Admin' : 'Enable Admin' }}"
                                            class="toggleAdminBtn w-9 h-9 rounded-xl flex items-center justify-center transition
                                            {{ $admin->is_active ? 'bg-red-100 hover:bg-red-200 text-red-600'
                                            : 'bg-green-100 hover:bg-green-200 text-green-600' }}">
                                                <i class="fa-solid {{ $admin->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                            </button>
                                        </form>

                                        {{-- EDIT --}}
                                        <button type="button" data-id="{{ $admin->id }}" data-name="{{ $admin->name }}" data-email="{{ $admin->email }}" title="Edit"
                                        class="editAdminBtn bg-amber-100 hover:bg-amber-200 text-amber-600 w-9 h-9 rounded-xl flex items-center justify-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        {{-- DELETE --}}
                                        <form method="POST" action="{{ route('super.users.destroy',$admin->id) }}" class="deleteAdminForm">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" data-action="{{ route('super.users.destroy',$admin->id) }}" title="Hapus"
                                            class="deleteAdminBtn bg-red-100 hover:bg-red-200 text-red-600 w-9 h-9 rounded-xl flex items-center justify-center">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- CARD PAGINATION --}}
        @if($admins->hasPages())
            <div class="mt-4 bg-white rounded-2xl shadow-lg border px-4 md:px-6 py-4">
                {{ $admins->links() }}
            </div>
        @endif
    </div>

    <div id="createAdminModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-[99999] opacity-0 transition-all duration-200">
        <div class="modal-content bg-white w-[90%] sm:max-w-md p-6 rounded-2xl shadow-xl scale-95 opacity-0 transition-all duration-200">
            <h2 class="text-lg font-semibold mb-4">
                Tambah Admin
            </h2>
            <form method="POST" action="{{ route('super.users.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-sm">
                        Nama Admin
                    </label>
                    <input type="text"name="name" autocomplete="off" required class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="text-sm">
                        Email
                    </label>
                    <input type="email" name="email" required class="w-full border rounded-lg p-2">
                </div>
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 mt-4">
                    <button type="button" id="closeCreateAdmin" class="px-4 py-2 border rounded-lg">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteAdminModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-[99999] opacity-0 transition-all duration-200">
        <div class="modal-content bg-white w-[90%] sm:max-w-sm p-6 rounded-2xl shadow-xl text-center scale-95 opacity-0 transition-all duration-200">
            <div class="mb-4">
                <i class="fa-solid fa-triangle-exclamation text-red-500 text-3xl"></i>
            </div>
            <h2 class="text-lg font-semibold mb-2">
                Hapus Admin
            </h2>
            <p class="text-sm text-gray-500 mb-6">
                Yakin ingin menghapus admin ini?
            </p>
            <div class="flex gap-2">
                <button id="cancelDeleteAdmin" class="flex-1 px-4 py-2 border rounded-lg">
                    Batal
                </button>
                <form id="deleteAdminForm" method="POST" class="flex-1 deleteAdminForm">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="deleteAdminSubmit w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div id="editAdminModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-[99999]">
        <div class="modal-content bg-white w-[90%] sm:max-w-md p-6 rounded-2xl shadow-xl scale-95 opacity-0 transition-all duration-200 ">
            <h2 class="text-lg font-semibold mb-4">
                Edit Admin
            </h2>
            <form id="editAdminForm" method="POST" class="space-y-4 editAdminForm">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm">
                        Nama
                    </label>
                    <input type="text" name="name" id="editAdminName" class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="text-sm">
                        Email
                    </label>
                    <input type="email" name="email" id="editAdminEmail" class="w-full border rounded-lg p-2">
                </div>
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-2">
                    <button type="button" id="closeEditAdmin" class="px-4 py-2 border rounded-lg">
                        Batal
                    </button>
                    <button type="submit" class="editAdminSubmit bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @vite('resources/js/modules/super-admin/superAdminUsers.js')

</x-app-layout>