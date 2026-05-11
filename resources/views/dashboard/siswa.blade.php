@extends('layouts.master')
@section('title', 'Dashboard Siswa')
@section('header', 'Dashboard Siswa')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-check-circle"></i>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span class="font-medium text-sm">{{ session('error') }}</span>
        </div>
    @endif

    {{-- SELAMAT DATANG --}}
    <div class="bg-gradient-to-r from-sky-500 to-indigo-600 rounded-2xl p-6 text-white shadow-xl shadow-sky-500/20">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <p class="text-sky-100 text-sm font-medium mb-1">Selamat datang,</p>
                <h2 class="text-2xl font-bold">{{ Auth::user()->name }}</h2>
                <p class="text-sky-200 text-sm mt-1">Koperasi Sekolah — Belanja mudah, cepat, dan aman</p>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20 flex-shrink-0">
                <i class="fa-solid fa-graduation-cap text-2xl"></i>
            </div>
        </div>
    </div>

    {{-- SALDO --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-sky-50 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-wallet text-sky-500 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Saldo Koperasi</p>
                <p class="text-2xl font-bold text-gray-800">
                    Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-user text-emerald-500 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">NISN</p>
                <p class="text-lg font-bold text-gray-800">{{ Auth::user()->nisn ?? '-' }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-violet-50 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-envelope text-violet-500 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Email</p>
                <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>

    {{-- PINTASAN CEPAT --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 text-base mb-4 flex items-center gap-2">
            <i class="fa-solid fa-bolt text-amber-400"></i> Pintasan Cepat
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('pembelian.index') }}"
                class="flex flex-col items-center gap-3 p-4 bg-sky-50 hover:bg-sky-100 rounded-2xl border border-sky-100 transition group">
                <div class="w-12 h-12 rounded-xl bg-sky-500 group-hover:bg-sky-600 flex items-center justify-center shadow-md shadow-sky-500/30 transition">
                    <i class="fa-solid fa-store text-white text-xl"></i>
                </div>
                <span class="text-sm font-semibold text-sky-700">Belanja</span>
            </a>

            <a href="{{ route('riwayat.index') }}"
                class="flex flex-col items-center gap-3 p-4 bg-emerald-50 hover:bg-emerald-100 rounded-2xl border border-emerald-100 transition group">
                <div class="w-12 h-12 rounded-xl bg-emerald-500 group-hover:bg-emerald-600 flex items-center justify-center shadow-md shadow-emerald-500/30 transition">
                    <i class="fa-solid fa-clock-rotate-left text-white text-xl"></i>
                </div>
                <span class="text-sm font-semibold text-emerald-700">Riwayat</span>
            </a>

            <!-- <a href="{{ route('profile.edit') }}"
                class="flex flex-col items-center gap-3 p-4 bg-violet-50 hover:bg-violet-100 rounded-2xl border border-violet-100 transition group">
                <div class="w-12 h-12 rounded-xl bg-violet-500 group-hover:bg-violet-600 flex items-center justify-center shadow-md shadow-violet-500/30 transition">
                    <i class="fa-solid fa-user-pen text-white text-xl"></i>
                </div>
                <span class="text-sm font-semibold text-violet-700">Profil</span>
            </a> -->

            <!-- <div class="flex flex-col items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <div class="w-12 h-12 rounded-xl bg-slate-300 flex items-center justify-center">
                    <i class="fa-solid fa-circle-info text-white text-xl"></i>
                </div>
                <span class="text-sm font-semibold text-slate-500 text-center">Hubungi Admin untuk Top Up</span>
            </div> -->
        </div>
    </div>

</div>
@endsection
