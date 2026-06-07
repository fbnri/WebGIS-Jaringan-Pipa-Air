<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold">
                Pengaturan Akun
            </h1>
            <p class="text-gray-500 text-sm">
                Kelola profil dan keamanan akun.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="font-semibold text-lg mb-4">
                    Profil Akun
                </h2>
                <form method="POST" action="{{ route('settings.profile') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <input name="name" value="{{ auth()->user()->name }}" class="w-full rounded-xl border-gray-300" placeholder="Nama">
                    <input name="email" value="{{ auth()->user()->email }}" class="w-full rounded-xl border-gray-300" placeholder="Email">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl">
                        Update Profil
                    </button>
                </form>
            </div>
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="font-semibold text-lg mb-4">
                    Ganti Password
                </h2>
                <form method="POST" action="{{ route('settings.password') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- PASSWORD LAMA --}}
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-3 text-gray-400"></i>
                        <input id="current_password" type="password" name="current_password"
                        placeholder="Password Lama" class="w-full pl-10 pr-10 rounded-xl border-gray-300">
                        <button type="button" id="toggleCurrent" 
                        class="absolute right-3 top-3 text-gray-400 hover:text-blue-600">
                            <i id="iconCurrent" class="fa-solid fa-eye"></i>
                        </button>
                    </div>

                    {{-- PASSWORD BARU --}}
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-3 text-gray-400"></i>
                        <input id="new_password" type="password" name="password"
                        placeholder="Password Baru" class="w-full pl-10 pr-10 rounded-xl border-gray-300">
                        <button type="button" id="toggleNew"
                        class="absolute right-3 top-3 text-gray-400 hover:text-blue-600">
                            <i id="iconNew" class="fa-solid fa-eye"></i>
                        </button>
                    </div>

                    {{-- KONFIRMASI --}}
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-3 text-gray-400"></i>
                        <input id="confirm_password" type="password" name="password_confirmation"
                        placeholder="Konfirmasi Password" class="w-full pl-10 pr-10 rounded-xl border-gray-300">
                        <button type="button" id="toggleConfirm"
                        class="absolute right-3 top-3 text-gray-400 hover:text-blue-600">
                            <i id="iconConfirm" class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    <button class="bg-gray-900 hover:bg-gray-700 text-white px-5 py-2 rounded-xl">
                        Ganti Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId){
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if(input.type === 'password'){
                input.type = 'text';
                icon.classList.replace(
                    'fa-eye',
                    'fa-eye-slash'
                );
            } else {
                input.type = 'password';
                icon.classList.replace(
                    'fa-eye-slash',
                    'fa-eye'
                );
            }
        }

        document.getElementById('toggleCurrent')
        .addEventListener('click', function(){
            togglePassword(
                'current_password',
                'iconCurrent'
            );
        });

        document.getElementById('toggleNew')
        .addEventListener('click', function(){
            togglePassword(
                'new_password',
                'iconNew'
            );
        });

        document.getElementById('toggleConfirm')
        .addEventListener('click', function(){
            togglePassword(
                'confirm_password',
                'iconConfirm'
            );
        });

        const passwordInputs = [
            document.getElementById('current_password'),
            document.getElementById('new_password'),
            document.getElementById('confirm_password')
        ];

        passwordInputs.forEach((input, index) => {
            input.addEventListener('keydown', function(e){
                if(e.key === 'Enter'){
                    e.preventDefault();

                    const nextInput = passwordInputs[index + 1];

                    if(nextInput){
                        nextInput.focus();
                    }
                }
            });
        });
    </script>

    @if(session('success'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            showToast(
                "{{ session('success') }}",
                "success"
            );
        });
    </script>
    @endif

    @if($errors->any())
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            showToast(
                "{{ $errors->first() }}",
                "error"
            );
        });
    </script>
    @endif
</x-app-layout>