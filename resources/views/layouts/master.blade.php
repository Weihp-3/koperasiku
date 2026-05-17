<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('favicon-512.png') }}">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <title>@yield('title', 'KoperasiKU')</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
        #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 40;
            backdrop-filter: blur(2px);
        }
        #sidebar-overlay.active { display: block; }
        #sidebar { transition: transform 0.3s ease; }
        @media (max-width: 767px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                z-index: 50;
                display: block !important;
                transform: translateX(-100%);
            }
            #sidebar.open { transform: translateX(0); }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">

        <div id="sidebar-overlay" onclick="closeSidebar()"></div>

        <aside id="sidebar" class="w-64 bg-white border-r hidden md:flex flex-col flex-shrink-0">
            <div class="h-16 flex items-center justify-between px-6 border-b">
                <div class="flex items-center gap-3">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2L2 7l10 5 10-5-10-5z" fill="#0EA5E9" opacity="0.9"/>
                        <path d="M2 17l10 5 10-5M2 12l10 5 10-5"
                            stroke="#0EA5E9"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            fill="none"/>
                    </svg>
                </div>
                <h2 class="font-bold text-gray-800 text-lg">KOPERASIKU</h2>
                <button onclick="closeSidebar()" class="md:hidden text-gray-400 hover:text-gray-600 text-xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <nav class="mt-4 px-4">
                <div class="space-y-3">
                    <p class="text-xs text-gray-400 uppercase mb-2 font-medium">Menu Utama</p>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm
                        transition-all duration-200 transform hover:translate-x-1 active:scale-95
                        hover:shadow-[0_6px_12px_rgba(27,168,240,0.6)]
                        {{ request()->routeIs('dashboard') || request()->routeIs('siswa.dashboard') || request()->routeIs('admin.dashboard') ? 'bg-sky-400 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-house w-4"></i>
                        Dashboard
                    </a>
                </div>

                @if(Auth::user()->role === 'siswa')
                <div class="space-y-3" style="margin-top: 1.5rem;">
                    <p class="text-xs text-gray-400 uppercase mb-2 font-medium">Layanan</p>
                    <a href="{{ route('pembelian.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm
                        transition-all duration-200 transform hover:translate-x-1 active:scale-95
                        hover:shadow-[0_6px_12px_rgba(27,168,240,0.4)]
                        {{ request()->routeIs('pembelian.*') ? 'bg-sky-400 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-cart-shopping w-4"></i>
                        Pembelian
                    </a>
                    <a href="{{ route('riwayat.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm
                        transition-all duration-200 transform hover:translate-x-1 active:scale-95
                        hover:shadow-[0_6px_12px_rgba(27,168,240,0.4)]
                        {{ request()->routeIs('riwayat.*') ? 'bg-sky-400 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-clock-rotate-left w-4"></i>
                        Riwayat
                    </a>
                </div>
                @endif
                @if(Auth::user()->role === 'admin')
                <div class="space-y-3" style="margin-top: 1.5rem;">
                    <p class="text-xs text-gray-400 uppercase mb-2 font-medium">Manajemen</p>
                    <a href="{{ route('admin.siswa.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm
                        transition-all duration-200 transform hover:translate-x-1 active:scale-95
                        hover:shadow-[0_6px_12px_rgba(27,168,240,0.4)]
                        {{ request()->routeIs('admin.siswa.*') ? 'bg-sky-400 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-users w-4"></i>
                        Siswa
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm
                        transition-all duration-200 transform hover:translate-x-1 active:scale-95
                        hover:shadow-[0_6px_12px_rgba(27,168,240,0.4)]
                        {{ request()->routeIs('products.*') ? 'bg-sky-400 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-box w-4"></i>
                        Produk
                    </a>
                    <a href="{{ route('laporan.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm
                        transition-all duration-200 transform hover:translate-x-1 active:scale-95
                        hover:shadow-[0_6px_12px_rgba(27,168,240,0.4)]
                        {{ request()->routeIs('laporan.*') ? 'bg-sky-400 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-chart-line w-4"></i>
                        Laporan
                    </a>
                    <a href="{{ route('admin.topup.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm
                        transition-all duration-200 transform hover:translate-x-1 active:scale-95
                        hover:shadow-[0_6px_12px_rgba(27,168,240,0.4)]
                        {{ request()->routeIs('admin.topup.*') ? 'bg-sky-400 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg width="20" height="20" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.4375 20.6666C17.4375 21.1805 17.2334 21.6733 16.87 22.0366C16.5067 22.4 16.0139 22.6041 15.5 22.6041C14.9861 22.6041 14.4933 22.4 14.13 22.0366C13.7666 21.6733 13.5625 21.1805 13.5625 20.6666C13.5625 20.1528 13.7666 19.66 14.13 19.2966C14.4933 18.9333 14.9861 18.7291 15.5 18.7291C16.0139 18.7291 16.5067 18.9333 16.87 19.2966C17.2334 19.66 17.4375 20.1528 17.4375 20.6666Z" fill="currentColor"/>
                            <path d="M18.5315 0.852539L22.639 6.60821L25.3477 5.68466L27.8199 12.9167H29.0625V28.4167H1.9375V12.9167H2.59625V12.9038L3.43325 12.9115L18.5315 0.852539ZM12.1378 12.9167H25.0906L23.7512 8.99908L21.7852 9.62812L12.1378 12.9167ZM10.1254 10.872L20.0854 7.47879L18.0136 4.57254L10.1254 10.872ZM7.10417 15.5H4.52083V18.0834C5.20598 18.0834 5.86306 17.8112 6.34753 17.3267C6.83199 16.8423 7.10417 16.1852 7.10417 15.5ZM20.0208 20.6667C20.0208 20.073 19.9039 19.4852 19.6767 18.9367C19.4495 18.3882 19.1165 17.8898 18.6967 17.47C18.2769 17.0502 17.7785 16.7172 17.23 16.49C16.6816 16.2628 16.0937 16.1459 15.5 16.1459C14.9063 16.1459 14.3184 16.2628 13.77 16.49C13.2215 16.7172 12.7231 17.0502 12.3033 17.47C11.8835 17.8898 11.5505 18.3882 11.3233 18.9367C11.0961 19.4852 10.9792 20.073 10.9792 20.6667C10.9792 21.8657 11.4555 23.0156 12.3033 23.8634C13.1511 24.7112 14.301 25.1875 15.5 25.1875C16.699 25.1875 17.8489 24.7112 18.6967 23.8634C19.5445 23.0156 20.0208 21.8657 20.0208 20.6667ZM26.4792 25.8334V23.25C25.794 23.25 25.1369 23.5222 24.6525 24.0067C24.168 24.4911 23.8958 25.1482 23.8958 25.8334H26.4792ZM23.8958 15.5C23.8958 16.1852 24.168 16.8423 24.6525 17.3267C25.1369 17.8112 25.794 18.0834 26.4792 18.0834V15.5H23.8958ZM4.52083 25.8334H7.10417C7.10417 25.1482 6.83199 24.4911 6.34753 24.0067C5.86306 23.5222 5.20598 23.25 4.52083 23.25V25.8334Z" fill="currentColor"/>
                        </svg>
                        Top Up Siswa
                    </a>
                    <a href="{{ route('admin.transactions.pending') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm
                        transition-all duration-200 transform hover:translate-x-1 active:scale-95
                        hover:shadow-[0_6px_12px_rgba(27,168,240,0.4)]
                        {{ request()->routeIs('admin.transactions.pending') ? 'bg-sky-400 text-white shadow' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fa-solid fa-list-check w-4"></i>
                        Verifikasi Bayar
                    </a>
                </div>
                @endif
            </nav>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white h-16 border-b px-4 md:px-6 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-3">
                    <button onclick="openSidebar()" class="md:hidden text-gray-500 hover:text-blue-500 transition text-xl">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h1 class="text-base md:text-lg font-semibold text-gray-700">
                        @yield('header', 'Dashboard')
                    </h1>
                </div>
                <div class="flex items-center gap-3 md:gap-5">
                    <button class="text-gray-500 hover:text-blue-500 transition">
                        <i class="fa-regular fa-bell text-lg"></i>
                    </button>
                    <div class="flex items-center gap-2">
                        <svg width="35" height="35" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.1755 3.50879C10.9755 3.50879 3.50879 10.9755 3.50879 20.1755C3.50879 29.3755 10.9755 36.8421 20.1755 36.8421C29.3755 36.8421 36.8421 29.3755 36.8421 20.1755C36.8421 10.9755 29.3755 3.50879 20.1755 3.50879ZM20.1755 10.1755C23.3921 10.1755 26.0088 12.7921 26.0088 16.0088C26.0088 19.2255 23.3921 21.8421 20.1755 21.8421C16.9588 21.8421 14.3421 19.2255 14.3421 16.0088C14.3421 12.7921 16.9588 10.1755 20.1755 10.1755ZM20.1755 33.5088C16.7921 33.5088 12.7921 32.1421 9.94212 28.7088C12.8618 26.4192 16.465 25.1748 20.1755 25.1748C23.8859 25.1748 27.4891 26.4192 30.4088 28.7088C27.5588 32.1421 23.5588 33.5088 20.1755 33.5088Z" fill="black"/>
                        </svg>
                        {{-- <div class="w-9 h-9 bg-blue-500 text-white flex items-center justify-center rounded-full text-sm font-semibold flex-shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div> --}}
                        <span class="hidden sm:block text-sm font-medium text-gray-700 truncate max-w-[120px]">
                            {{ Auth::user()->name }}
                        </span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-red-500 transition" title="Logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </header>

            <main class="p-4 md:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('sidebar-overlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebar-overlay').classList.remove('active');
            document.body.style.overflow = '';
        }
    </script>

    @stack('scripts')
</body>
</html>
