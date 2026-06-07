<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border p-8">

            {{-- HEADER --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-map-location-dot text-blue-600"></i>
                    WebGIS Pipa Air
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Sistem Manajemen Jaringan Pipa Air
                </p>
            </div>

            {{-- ALERT ERROR LOGIN --}}
            @if ($errors->any())
                <div id="toastError"
                    class="fixed top-5 right-5 z-[9999] flex items-center gap-3
                    px-4 py-3 rounded-xl shadow-lg text-white text-sm
                    bg-red-600 transform translate-x-full opacity-0
                    transition-all duration-300">
                    <i class="fa-solid fa-circle-xmark text-lg"></i>
                    <span>
                        {{ $errors->first('email') ?? $errors->first() }}
                    </span>
                </div>
            @endif

            {{-- STATUS --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- EMAIL --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                        Email
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3 top-3 text-gray-400"></i>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required autofocus
                            class="pl-10 mt-1 block w-full rounded-xl border-gray-300 focus:ring-2 
                            focus:ring-blue-500 focus:border-blue-500 transition"
                        />
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                        Password
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-3 text-gray-400"></i>

                        {{-- INPUT --}}
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            auto-capitalize="off"
                            spellcheck="false"
                            class="pl-10 pr-10 mt-1 block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-2 
                            focus:ring-blue-500 transition"
                        />

                        {{-- ICON MATA --}}
                        <button type="button" id="togglePassword"
                        class="absolute right-3 top-3 text-gray-400 hover:text-blue-600">
                            <i id="eyeIcon" class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- BUTTON --}}
                <div class="pt-2">
                    <button type="submit" id="loginBtn"
                    class="mt-5 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition 
                    shadow hover:shadow-lg active:scale-[0.98] flex items-center justify-center gap-2">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span id="btnText">Login</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ALERT TOAST ERROR
        window.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('toastError');

            if (toast) {
                setTimeout(() => {
                    toast.classList.remove('translate-x-full','opacity-0');
                }, 50);

                setTimeout(() => {
                    toast.classList.add('translate-x-full','opacity-0');
                }, 3000);
            }
        });

        // TOGGLE PASSWORD
        document.getElementById('togglePassword').addEventListener('click', function () {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    </script>
</x-guest-layout>