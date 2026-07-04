<div x-data="sidebar" class="flex w-full overflow-x-hidden">
    <div 
    x-show="sidebarOpen"  
    @click="closeSidebar()" 
    class="fixed inset-0 bg-black bg-opacity-40 z-30 md:hidden">
    </div>

    {{-- SIDEBAR --}}
    <aside
    :class="[
        sidebarOpen ? 'translate-x-0' : '-translate-x-full',
        sidebarCollapsed ? 'md:w-20 w-64' : 'md:w-64 w-64'
    ]"
    class="h-screen bg-gray-900 text-white fixed md:translate-x-0 transform transition-all duration-200 ease-out flex flex-col z-40">
        <div
        :class="sidebarCollapsed
        ? 'md:flex md:justify-center md:items-center md:px-0 md:py-4 flex justify-center items-center px-0 py-4'
        : 'flex items-center px-5 py-5'"
        class="border-b border-gray-700">
            <h1
            :class="sidebarCollapsed
            ? 'md:flex md:items-center md:justify-center md:w-full flex items-center justify-center w-full'
            : 'flex items-center gap-2'"
            class="text-md font-bold">
                <i
                :class="sidebarCollapsed
                ? 'md:text-2xl md:translate-x-[3px] text-lg'
                : 'text-lg'"
                class="fa-solid fa-map-location-dot transition-all duration-300"></i>
                <span
                :class="sidebarCollapsed
                ? 'md:opacity-0 md:max-w-0 md:overflow-hidden opacity-100 max-w-xs ml-2'
                : 'opacity-100 max-w-xs ml-2'"
                class="transition-all duration-300 whitespace-nowrap inline-block">
                    WebGIS Jaringan Pipa
                </span>
            </h1>
        </div>

        {{-- USER PROFILE --}}
        <div class="px-4 py-5 border-b border-gray-700">
            <div
            :class="sidebarCollapsed
            ? 'md:flex md:flex-col md:items-center md:justify-center flex items-center justify-between w-full'
            : 'flex items-center justify-between w-full'"
            class="transition-all duration-300">
                <div
                :class="sidebarCollapsed
                ? 'md:flex md:flex-col md:items-center md:justify-center w-full flex items-center gap-3'
                : 'flex items-center gap-3'">
                    <div
                    :class="sidebarCollapsed ? 'md:w-11 md:h-11 w-9 h-9' : 'w-9 h-9'"
                    class="rounded-full bg-blue-600 flex items-center justify-center text-sm font-semibold text-white">
                        {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                    </div>
                    <div
                    :class="sidebarCollapsed ? 'md:hidden block' : 'block'">
                        <p class="text-sm font-semibold leading-tight">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ auth()->user()->role == 'super_admin'
                            ? 'Super Administrator'
                            : 'Administrator' }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('settings.index') }}"
                :class="sidebarCollapsed ? 'md:hidden flex' : 'flex'"
                class="w-8 h-8 rounded-full bg-gray-700 hover:bg-gray-600 items-center justify-center text-gray-300 hover:text-white transition">
                    <i class="fa-solid fa-gear text-lg"></i>
                </a>
            </div>
        </div>
        <div class="flex flex-col h-full">
            <nav class="p-4 space-y-2 text-sm">

                {{-- DASHBOARD --}}
                <a href="{{ route('admin.dashboard') }}"
                :class="sidebarCollapsed
                ? 'md:justify-center md:gap-0 gap-3'
                : 'gap-3'"
                class="group flex items-center px-3 py-2 rounded-lg
                {{ request()->routeIs('admin.dashboard*')
                ? 'bg-gray-800 text-white'
                : 'hover:bg-gray-800 text-gray-300' }}">
                    <i class="fa-solid fa-chart-line w-5 text-center flex-shrink-0 transition-transform duration-200 group-hover:scale-110"></i>
                    <span :class="sidebarCollapsed ? 'md:hidden inline-block ml-2' : 'inline-block ml-2'">
                        Dashboard
                    </span>
                </a>

                {{-- DATA PIPA --}}
                <a href="{{ route('admin.pipes.index') }}"
                :class="sidebarCollapsed
                ? 'md:justify-center md:gap-0 gap-3'
                : 'gap-3'"
                class="group flex items-center px-3 py-2 rounded-lg
                {{ request()->routeIs('admin.pipes.*')
                ? 'bg-gray-800 text-white'
                : 'hover:bg-gray-800 text-gray-300' }}">
                    <i class="fa-solid fa-database w-5 text-center flex-shrink-0 transition-transform duration-200 group-hover:scale-110"></i>
                    <span
                    :class="sidebarCollapsed
                    ? 'md:hidden inline-block ml-2'
                    : 'inline-block ml-2'">
                        Data Pipa
                    </span>
                </a>

                {{-- SUPER ADMIN --}}
                @if(auth()->user()->role == 'super_admin')
                    <a href="{{ route('super.users') }}"
                    :class="sidebarCollapsed
                    ? 'md:justify-center md:gap-0 gap-3'
                    : 'gap-3'"
                    class="group flex items-center px-3 py-2 rounded-lg
                    {{ request()->routeIs('super.users*')
                    ? 'bg-gray-800 text-white'
                    : 'hover:bg-gray-800 text-gray-300' }}">
                        <i class="fa-solid fa-users-gear w-5 text-center flex-shrink-0 transition-transform duration-200 group-hover:scale-110"></i>
                        <span
                        :class="sidebarCollapsed
                        ? 'md:hidden inline-block ml-2'
                        : 'inline-block ml-2'">
                            Kelola Admin
                        </span>
                    </a>
                @endif
            </nav>
            <div class="mt-auto p-4">
                <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                    id="logoutBtn"
                    type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span
                        id="logoutBtnText"
                        :class="sidebarCollapsed
                        ? 'md:hidden inline-block'
                        : 'inline-block'">
                            Logout
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- CONTENT WRAPPER --}}
    <div
    :class="sidebarCollapsed ? 'md:ml-20' : 'md:ml-64'"
    class="flex-1 min-h-screen bg-gray-100 transition-all duration-300 w-full overflow-x-hidden">

        {{-- TOP NAV --}}
        <header class="bg-white shadow h-16 flex items-center px-6">
            <div class="flex items-center gap-3 flex-1">
                <button @click="toggleSidebar()" class="md:hidden text-gray-600">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <button @click="toggleCollapse()" class="hidden md:block text-gray-600">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="flex-1 flex justify-end">
                    <h1 class="text-md md:text-lg font-semibold text-gray-700 text-right">
                        Sistem Monitoring Pipa
                    </h1>
                </div>
            </div>
        </header>

        <main class="p-6">
            {{ $slot }}
        </main>
    </div>
</div>