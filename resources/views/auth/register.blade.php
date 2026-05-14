<x-guest-layout>

    <div class="auth-form-title">Buat Akun Baru</div>
    <div class="auth-form-sub">Isi data di bawah untuk mendaftar sebagai siswa koperasi.</div>

    @if ($errors->any())
        <div style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;border-radius:10px;padding:0.75rem 1rem;font-size:0.8125rem;margin-bottom:1rem;">
            <i class="fa-solid fa-circle-exclamation" style="margin-right:6px;"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nama Lengkap --}}
        <div class="field-group">
            <label class="field-label" for="name">Nama Lengkap</label>
            <div class="field-wrap">
                <i class="fa-solid fa-user field-icon"></i>
                <input
                    id="name"
                    class="field-input"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    placeholder="Nama lengkap Anda"
                >
            </div>
            @error('name')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>


        {{-- Email --}}
        <div class="field-group">
            <label class="field-label" for="email">Email</label>
            <div class="field-wrap">
                <i class="fa-solid fa-envelope field-icon"></i>
                <input
                    id="email"
                    class="field-input"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    placeholder="email@sekolah.com"
                >
            </div>
            @error('email')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- Password --}}
        <div class="field-group">
            <label class="field-label" for="password">Password</label>
            <div class="field-wrap">
                <i class="fa-solid fa-lock field-icon"></i>
                <input
                    id="password"
                    class="field-input field-input-right"
                    type="password"
                    name="password"
                    required
                    placeholder="Min. 8 karakter"
                >
                <span class="field-icon-right" onclick="togglePwd('password','eyePass')">
                    <i class="fa-solid fa-eye-slash" id="eyePass"></i>
                </span>
            </div>
            @error('password')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div class="field-group">
            <label class="field-label" for="password_confirmation">Konfirmasi Password</label>
            <div class="field-wrap">
                <i class="fa-solid fa-lock field-icon"></i>
                <input
                    id="password_confirmation"
                    class="field-input field-input-right"
                    type="password"
                    name="password_confirmation"
                    required
                    placeholder="Ulangi password Anda"
                >
                <span class="field-icon-right" onclick="togglePwd('password_confirmation','eyeConfirm')">
                    <i class="fa-solid fa-eye-slash" id="eyeConfirm"></i>
                </span>
            </div>
            @error('password_confirmation')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-auth">
            <i class="fa-solid fa-user-plus" style="margin-right:8px;"></i>
            Daftar Sekarang
        </button>
    </form>

    <div class="auth-divider">atau</div>

    <a href="{{ route('auth.google') }}" class="btn-auth" style="background:#fff;color:#333;border:1px solid #e5e7eb;margin-bottom:1rem;display:flex;align-items:center;justify-content:center;text-decoration:none;font-weight:500;transition:all 0.3s;box-shadow:0 1px 2px rgba(0,0,0,0.05);" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" style="width:20px;margin-right:10px;">
        Daftar dengan Google
    </a>

    <div class="auth-footer-link">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>

    <script>
        function togglePwd(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon  = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            }
        }
    </script>

</x-guest-layout>
