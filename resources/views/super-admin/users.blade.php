<x-app-layout>
    <div
        id="adminPageData"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}"
        hidden>
    </div>

    <div class="p-4 md:p-6 space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Kelola Admin
                </h1>
                <p class="text-sm text-gray-500">
                    Manajemen akun administrator
                </p>
            </div>
            <button id="openCreateAdmin" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow text-sm">
                <i class="fa-solid fa-plus mr-1"></i>
                Tambah Admin
            </button>
        </div>

        {{-- CARD TABLE --}}
        <div class="bg-white rounded-2xl shadow-lg border overflow-hidden">
            <div class="overflow-x-auto scrollbar-thin">
                <table class="w-full text-sm">

                    {{-- HEADER TABLE --}}
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-4 text-left">
                                Nama
                            </th>
                            <th class="px-6 py-4 text-left">
                                Email
                            </th>
                            <th class="px-6 py-4 text-left">
                                Status
                            </th>
                            <th class="px-6 py-4 text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($admins as $admin)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ $admin->name }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $admin->email }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($admin->is_active)
                                        <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">

                                        {{-- RESET PASSWORD --}}
                                        <form method="POST"
                                        action="{{ route('super.users.reset',$admin->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button
                                            title="Reset Password"
                                            class="bg-blue-600 hover:bg-blue-700 text-white w-9 h-9 rounded-lg flex items-center justify-center">
                                                <i class="fa-solid fa-key"></i>
                                            </button>
                                        </form>

                                        {{-- DISABLE / ENABLE --}}
                                        <form method="POST"
                                        action="{{ route('super.users.toggle',$admin->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button
                                            title="{{ $admin->is_active ? 'Disable Admin' : 'Enable Admin' }}"
                                            class="bg-red-600 hover:bg-red-700 text-white w-9 h-9 rounded-lg flex items-center justify-center">
                                                <i class="fa-solid {{ $admin->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                            </button>
                                        </form>

                                        {{-- EDIT --}}
                                        <button type="button" data-id="{{ $admin->id }}" data-name="{{ $admin->name }}" data-email="{{ $admin->email }}" title="Edit"
                                        class="editAdminBtn bg-amber-500 hover:bg-amber-600 text-white w-9 h-9 rounded-lg flex items-center justify-center">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        {{-- DELETE --}}
                                        <form method="POST" action="{{ route('super.users.destroy',$admin->id) }}" class="deleteAdminForm">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" data-action="{{ route('super.users.destroy',$admin->id) }}" title="Hapus"
                                            class="deleteAdminBtn bg-gray-800 hover:bg-black text-white w-9 h-9 rounded-lg flex items-center justify-center">
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
                <form id="deleteAdminForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
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
            <form id="editAdminForm" method="POST" class="space-y-4">
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
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @vite('resources/js/modules/adminManagement.js')

</x-app-layout>