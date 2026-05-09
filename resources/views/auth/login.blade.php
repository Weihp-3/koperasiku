<x-guest-layout>
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold ">
                    🏪 KOPERASIKU
                </h2>
                <p class="text-gray-500 text-sm mt-2">
                    Sistem Manajemen Koperasi Sekolah
                </p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mt-4 relative">
                    <x-input-label for="email" :value="'Email'" />
                    <x-text-input
                        id="email"
                        class="block mt-1 w-full rounded-lg pr-10"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        placeholder="Username or Email"
                        autocomplete="username"/>
                    <div class="absolute right-0 flex items-center pr-3 pointer-events-none" style="top: 50%; transform: translateY(10%);">
                        <svg width="20" height="20" viewBox="0 0 34 34" fill="none">
                            <path d="M17 17C20.1308 17 22.6667 14.4641 22.6667 11.3333C22.6667 8.20246 20.1308 5.66663 17 5.66663C13.8692 5.66663 11.3333 8.20246 11.3333 11.3333C11.3333 14.4641 13.8692 17 17 17ZM17 19.8333C13.2175 19.8333 5.66667 21.7316 5.66667 25.5V26.9166C5.66667 27.6958 6.30417 28.3333 7.08334 28.3333H26.9167C27.6958 28.3333 28.3333 27.6958 28.3333 26.9166V25.5C28.3333 21.7316 20.7825 19.8333 17 19.8333Z" fill="#000000"/>
                        </svg>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4 relative">
                    <x-input-label for="password" :value="'Password'" />
                    <x-text-input id="password"
                        class="block mt-1 w-full rounded-lg pr-10"
                        type="password"
                        name="password"
                        :value="old('password')"
                        required
                        autofocus
                        placeholder="Password"
                        autocomplete="current-password" />
                    <div class="absolute right-0 flex items-center pr-3 cursor-pointer"
                        style="top: 50%; transform: translateY(10%);"
                        onclick="togglePassword()">

                        <svg id="icon-hide" width="20" height="20" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.5568 12.1428L21.0476 16.6195V16.3928C21.0476 15.2657 20.5998 14.1846 19.8028 13.3876C19.0058 12.5906 17.9248 12.1428 16.7976 12.1428H16.5568ZM10.4651 13.2762L12.6609 15.472C12.5901 15.7695 12.5476 16.067 12.5476 16.3928C12.5476 17.52 12.9954 18.601 13.7924 19.398C14.5894 20.1951 15.6704 20.6428 16.7976 20.6428C17.1093 20.6428 17.4209 20.6003 17.7184 20.5295L19.9143 22.7253C18.9651 23.1928 17.9168 23.4762 16.7976 23.4762C14.919 23.4762 13.1173 22.7299 11.7889 21.4015C10.4606 20.0731 9.71428 18.2714 9.71428 16.3928C9.71428 15.2737 9.99761 14.2253 10.4651 13.2762ZM2.63095 5.44199L5.86095 8.67199L6.49845 9.30949C4.16095 11.1512 2.31928 13.5595 1.21428 16.3928C3.66511 22.612 9.71428 27.0178 16.7976 27.0178C18.9934 27.0178 21.0901 26.5928 23.0026 25.8278L23.6118 26.4228L27.7484 30.5595L29.5476 28.7603L4.43011 3.64282M16.7976 9.30949C18.6762 9.30949 20.4779 10.0558 21.8063 11.3841C23.1347 12.7125 23.8809 14.5142 23.8809 16.3928C23.8809 17.2995 23.6968 18.1778 23.3709 18.9712L27.5218 23.122C29.6468 21.3512 31.3468 19.0278 32.3809 16.3928C29.9301 10.1737 23.8809 5.76782 16.7976 5.76782C14.8143 5.76782 12.9159 6.12199 11.1309 6.75949L14.2051 9.80532C15.0126 9.49366 15.8768 9.30949 16.7976 9.30949Z" fill="black"/>
                        </svg>

                        <svg id="icon-show" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="hidden">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5C17 19.5 21.27 16.39 23 12C21.27 7.61 17 4.5 12 4.5ZM12 17C9.24 17 7 14.76 7 12C7 9.24 9.24 7 12 7C14.76 7 17 9.24 17 12C17 14.76 14.76 17 12 17ZM12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9Z" fill="black"/>
                        </svg>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <script>
                    function togglePassword() {
                        const input = document.getElementById('password');
                        const iconHide = document.getElementById('icon-hide');
                        const iconShow = document.getElementById('icon-show');

                        if (input.type === 'password') {
                            input.type = 'text';
                            iconHide.classList.add('hidden');
                            iconShow.classList.remove('hidden');
                        } else {
                            input.type = 'password';
                            iconHide.classList.remove('hidden');
                            iconShow.classList.add('hidden');
                        }
                    }
                </script>

                <div class="flex items-center justify-between mt-4">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" name="remember"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ms-2">Ingat Saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:underline"
                            href="{{ route('password.request') }}">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-sky-400 hover:bg-sky-500 text-white font-semibold py-2 rounded-lg transition duration-200">
                        Masuk
                    </button>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('register') }}"
                        class="text-sm text-gray-600 hover:text-blue-600">
                        Belum punya akun? Daftar
                    </a>
                </div>
            </form>
</x-guest-layout>
