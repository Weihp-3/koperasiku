@extends('layouts.master')
@section('title', 'Manajemen Siswa')
@section('header', 'Data Siswa')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h2 class="text-lg font-bold text-gray-800">Daftar Siswa</h2>
        <p class="text-xs text-gray-400 mt-0.5">Kelola semua data siswa dan akun</p>
    </div>
    {{-- <a href="{{ route('admin.siswa.create') }}"
        class="bg-sky-400 hover:bg-sky-500 active:scale-95 text-white px-5 py-2.5
        rounded-xl text-sm font-medium flex items-center gap-2 transition
        w-full sm:w-auto justify-center shadow-sm">
        <i class="fa-solid fa-plus text-xs"></i> Tambah Siswa
    </a> --}}
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
                    <th class="px-5 py-4 text-left font-semibold">NISN</th>
                    <th class="px-5 py-4 text-left font-semibold">Email</th>
                    <th class="px-5 py-4 text-right font-semibold">Saldo</th>
                    <th class="px-5 py-4 text-center font-semibold" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($siswas as $index => $siswa)
                    <tr class="hover:bg-sky-50/30 transition duration-150">
                        <td class="px-5 py-4 text-center text-gray-400 text-xs">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-5 py-4 text-left">
                            <p class="font-semibold text-gray-800">{{ $siswa->name }}</p>
                        </td>
                        <td class="px-5 py-4 text-left text-gray-600">
                            {{ $siswa->nisn ?? '-' }}
                        </td>
                        <td class="px-5 py-4 text-left text-gray-600">
                            {{ $siswa->email }}
                        </td>
                        <td class="px-5 py-4 text-right font-semibold text-gray-800">
                            Rp {{ number_format($siswa->balance, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.siswa.edit', $siswa->id) }}"
                                    class="inline-flex items-center gap-1.5 bg-sky-400 hover:bg-sky-500
                                    active:scale-95 text-white px-3.5 py-1.5 rounded-lg text-xs
                                    font-medium transition">
                                    <i class="fa-solid fa-pen text-xs"></i> Edit
                                </a>
                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        onclick="return confirm('Hapus siswa ini? Semua data terkait (transaksi, dll) mungkin ikut terhapus atau menyebabkan error jika tidak ditangani.')"
                                        class="inline-flex items-center gap-1.5 border border-red-200
                                        bg-red-50 hover:bg-red-500 text-red-500 hover:text-white
                                        active:scale-95 px-3.5 py-1.5 rounded-lg text-xs font-medium transition">
                                        <i class="fa-solid fa-trash text-xs"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-16 text-gray-400">
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
