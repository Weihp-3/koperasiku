@extends('layouts.master')
@section('title', 'Manajemen Siswa')
@section('header', 'Data Siswa')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h2 class="text-lg font-bold text-gray-800">Daftar Siswa</h2>
        <p class="text-xs text-gray-400 mt-0.5">Kelola semua data siswa dan akun</p>
    </div>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl mb-4 text-sm flex items-center gap-2">
    <i class="fa-solid fa-circle-check"></i>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50 text-gray-400 text-xs uppercase tracking-wide">
                    <th class="px-5 py-4 text-center font-semibold" style="width: 50px;">No</th>
                    <th class="px-5 py-4 text-left font-semibold">Nama Siswa</th>
                    <th class="px-5 py-4 text-left font-semibold">Email</th>
                    <th class="px-5 py-4 text-right font-semibold">Saldo</th>
                    <th class="px-5 py-4 text-center font-semibold" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($siswas as $index => $siswa)
                    <tr class="hover:bg-sky-50/30 transition duration-150">
                        <!-- Nomor Index -->
                        <td class="px-5 py-4 text-center text-gray-500 text-sm align-middle">
                            {{ $index + 1 }}
                        </td>

                        <!-- Nama Siswa -->
                        <td class="px-5 py-4 text-left align-middle">
                            <p class="font-semibold text-gray-800">{{ $siswa->name }}</p>
                        </td>

                        <!-- Email -->
                        <td class="px-5 py-4 text-left text-gray-600 align-middle">
                            {{ $siswa->email }}
                        </td>

                        <!-- Saldo -->
                        <td class="px-5 py-4 text-right font-bold text-gray-800 align-middle">
                            Rp {{ number_format($siswa->balance, 0, ',', '.') }}
                        </td>

                        <!-- Tombol Aksi -->
                        <td class="px-5 py-4 text-center align-middle">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.siswa.edit', $siswa->id) }}"
                                    class="inline-flex items-center gap-1.5 bg-sky-400 hover:bg-sky-500
                                    active:scale-95 text-white px-3.5 py-2 rounded-lg text-xs
                                    font-medium transition">
                                    <i class="fa-solid fa-pen text-[10px]"></i> Edit
                                </a>
                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        onclick="return confirm('Hapus siswa ini?')"
                                        class="inline-flex items-center gap-1.5 border border-red-200
                                        bg-red-50 hover:bg-red-500 text-red-500 hover:text-white
                                        active:scale-95 px-3.5 py-2 rounded-lg text-xs font-medium transition">
                                        <i class="fa-solid fa-trash text-[10px]"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-16 text-gray-400">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                    <i class="fa-solid fa-users text-2xl text-gray-300"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-500 text-sm">Belum ada siswa</p>
                                    <p class="text-xs text-gray-400 mt-1">Tambahkan siswa pertama kamu</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
