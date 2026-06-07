<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border p-8">

            {{-- HEADER --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-shield-keyhole text-blue-600"></i>
                    Reset Password
                </h1>
                <p class="text-sm text-gray-500 mt-2">
                    Password Anda telah direset Super Admin.
                    Silakan buat password baru untuk melanjutkan.
                </p>
            </div>

            {{-- ERROR ALERT --}}
            @if ($errors->any())
                <div id="alertBox"
                    class="px-4 py-2.5 rounded-xl bg-red-100 border border-red-300
                    text-red-600 text-sm flex items-center justify-center gap-2
                    opacity-0 -translate-y-2 transition-all duration-300 overflow-hidden">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>
                        {{ $errors->first() }}
                    </span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.force.update') }}" class="space-y-5">
                @csrf

                {{-- PASSWORD BARU --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Password Baru
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-3 text-gray-400"></i>
                        <input id="password" type="password" name="password" required
                        class="pl-10 pr-10 w-full rounded-xl border-gray-300
                        focus:ring-2 focus:ring-blue-500
                        focus:border-blue-500 transition">

                        {{-- TOGGLE PASSWORD --}}
                        <button type="button" id="togglePassword"
                        class="absolute right-3 top-3 text-gray-400 hover:text-blue-600">
                            <i id="eyeIcon" class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                {{-- KONFIRMASI PASSWORD --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Konfirmasi Password
                    </label>

                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-3 text-gray-400"></i>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="pl-10 pr-10 w-full rounded-xl border-gray-300
                        focus:ring-2 focus:ring-blue-500
                        focus:border-blue-500 transition">

                        {{-- TOGGLE CONFIRM PASSWORD --}}
                        <button type="button" id="toggleConfirmPassword"
                        class="absolute right-3 top-3 text-gray-400 hover:text-blue-600">
                            <i id="eyeIconConfirm" class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                {{-- BUTTON --}}
                <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white
                py-2 rounded-lg font-semibold transition
                shadow hover:shadow-lg active:scale-[0.98]
                flex items-center justify-center gap-2">
                    <i class="fa-solid fa-key"></i>
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </div>

    <script>
        /* MAIN PASSWORD */
        document.getElementById('togglePassword').addEventListener('click', function(){
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if( input.type==='password' ){
                input.type='text';
                icon.classList.replace(
                    'fa-eye',
                    'fa-eye-slash'
                );
            }else{
                input.type='password';
                icon.classList.replace(
                    'fa-eye-slash',
                    'fa-eye'
                );
            }
        });

        /* CONFIRMATION */
        document.getElementById('toggleConfirmPassword').addEventListener('click', function(){
            const input = document.getElementById('password_confirmation');
            const icon = document.getElementById('eyeIconConfirm');

            if(input.type==='password'){
                input.type='text';
                icon.classList.replace(
                    'fa-eye',
                    'fa-eye-slash'
                );
            }else{
                input.type='password';
                icon.classList.replace(
                    'fa-eye-slash',
                    'fa-eye'
                );
            }
        });

        /* ALERT ANIMATION */
        window.addEventListener('DOMContentLoaded', ()=>{
            const alertBox = document.getElementById( 'alertBox');
            if(alertBox){

                setTimeout(()=>{
                    alertBox.classList.remove(
                        'opacity-0',
                        '-translate-y-2'
                    );

                    alertBox.classList.add(
                        'opacity-100',
                        'translate-y-0',
                        'mb-4'
                    );
                },50);

                setTimeout(()=>{
                    const h = alertBox.offsetHeight;

                    alertBox.style.height = h+'px';
                    alertBox.offsetHeight;
                    alertBox.style.height='0';
                    alertBox.classList.add('opacity-0');

                    setTimeout(()=>{
                        alertBox.style.display='none';
                    },300);
                },3000);
            }
        });
    </script>
</x-guest-layout>