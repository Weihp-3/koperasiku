@extends('layouts.master')
@section('title', 'Edit Data Siswa')
@section('header', 'Edit Data Siswa')
@section('content')

<div class="mb-5">
    <a href="{{ route('admin.siswa.index') }}" class="text-sm text-gray-500 hover:text-sky-500 transition flex items-center gap-2 w-fit">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Siswa
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-2xl">
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <h2 class="text-lg font-bold text-gray-800">Form Edit Siswa</h2>
        <p class="text-xs text-gray-500 mt-1">Perbarui data informasi akun siswa.</p>
    </div>

    @if ($errors->any())
    <div class="p-6 pb-0">
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="p-6">
        <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-5">
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $siswa->name) }}" placeholder="Masukkan nama lengkap" required {{ $siswa->google_id ? 'disabled' : '' }}
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition {{ $siswa->google_id ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                </div>

                <!-- <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                        NISN
                    </label>
                    <input type="text" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" placeholder="Masukkan NISN siswa"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition">
                </div> -->

                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $siswa->email) }}" placeholder="siswa@example.com" required {{ $siswa->google_id ? 'disabled' : '' }}
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition {{ $siswa->google_id ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                </div>

                <div class="p-4 bg-yellow-50/50 border border-yellow-100 rounded-xl mt-6">
                    <p class="text-xs text-yellow-600 mb-3"><i class="fa-solid fa-circle-info mr-1"></i> Kosongkan password jika tidak ingin mengubahnya.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                                Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" {{ $siswa->google_id ? 'disabled' : '' }}
                                    class="w-full border border-gray-200 rounded-xl pl-4 pr-10 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition {{ $siswa->google_id ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                                <button type="button" onclick="togglePassword('password', 'eye-icon-2')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-sky-500 transition">
                                    <i class="fa-regular fa-eye" id="eye-icon-2"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                                Konfirmasi Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" {{ $siswa->google_id ? 'disabled' : '' }}
                                    class="w-full border border-gray-200 rounded-xl pl-4 pr-10 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition {{ $siswa->google_id ? 'bg-gray-100 cursor-not-allowed' : '' }}">
                                <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-1')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-sky-500 transition">
                                    <i class="fa-regular fa-eye" id="eye-icon-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-5 border-t border-gray-100">
                <a href="{{ route('admin.siswa.index') }}"
                    class="px-5 py-2.5 rounded-xl text-sm font-medium border border-gray-200 text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition">
                    Batal
                </a>
                <button type="submit"
                    class="bg-sky-400 hover:bg-sky-500 active:scale-95 text-white px-6 py-2.5
                    rounded-xl text-sm font-medium transition shadow-sm {{ $siswa->google_id ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}" {{ $siswa->google_id ? 'disabled' : '' }}>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush
