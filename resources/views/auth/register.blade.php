<x-guest-layout>
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold">
                    🏪 KOPERASIKU
                </h2>
                <p class="text-gray-500 text-sm mt-2">
                    Buat Akun Baru
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <x-input-label for="name" :value="'Nama Lengkap'" />
                    <x-text-input id="name"
                        class="block mt-1 w-full rounded-lg"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="nisn" :value="'NISN (Nomor Induk Siswa Nasional)'" />
                    <x-text-input id="nisn"
                        class="block mt-1 w-full rounded-lg"
                        type="text"
                        name="nisn"
                        :value="old('nisn')" />
                    <x-input-error :messages="$errors->get('nisn')" class="mt-2" />

                </div>

                <div class="mt-4">
                    <x-input-label for="email" :value="'Email'" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-lg"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="'Password'" />
                    <x-text-input id="password"
                        class="block mt-1 w-full rounded-lg"
                        type="password"
                        name="password"
                        required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="'Konfirmasi Password'" />
                    <x-text-input id="password_confirmation"
                        class="block mt-1 w-full rounded-lg"
                        type="password"
                        name="password_confirmation"
                        required />
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-sky-400 hover:bg-sky-500 text-white font-semibold py-2 rounded-lg transition delay-150 duration-300 ease-in-out">
                        Daftar Sekarang
                    </button>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}"
                        class="text-sm text-gray-600 hover:text-blue-600">
                        Sudah punya akun? Masuk
                    </a>
                </div>
            </form>
</x-guest-layout>
