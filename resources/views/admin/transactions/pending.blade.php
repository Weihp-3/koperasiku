@extends('layouts.master')
@section('title', 'Verifikasi Pembayaran')
@section('header', 'Verifikasi Pembayaran')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h2 class="text-lg font-bold text-gray-800">Menunggu Verifikasi</h2>
        <p class="text-xs text-gray-400 mt-0.5">Daftar transaksi dengan pembayaran QRIS atau Tunai.</p>
    </div>
</div>

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-2">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50 text-gray-400 text-xs uppercase tracking-wide">
                    <th class="px-5 py-4 text-center font-semibold" style="width: 50px;">No</th>
                    <th class="px-5 py-4 text-left font-semibold">Tgl & Waktu</th>
                    <th class="px-5 py-4 text-left font-semibold">Nama Siswa</th>
                    <th class="px-5 py-4 text-left font-semibold">Metode</th>
                    <th class="px-5 py-4 text-right font-semibold">Total Tagihan</th>
                    <th class="px-5 py-4 text-center font-semibold" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($transactions as $index => $trx)
                    <tr class="hover:bg-sky-50/30 transition duration-150">
                        <td class="px-5 py-4 text-center text-gray-500 text-sm align-middle">
                            {{ $index + 1 }}
                        </td>
                        
                        <td class="px-5 py-4 text-left align-middle">
                            <p class="font-semibold text-gray-800">{{ $trx->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $trx->created_at->format('H:i') }} WIB</p>
                        </td>

                        <td class="px-5 py-4 text-left align-middle text-gray-600 font-medium">
                            {{ $trx->user->name ?? 'Anonim' }}
                        </td>

                        <td class="px-5 py-4 text-left align-middle">
                            @if($trx->payment_method === 'qris')
                                <span class="bg-blue-50 text-blue-600 text-xs font-bold px-2.5 py-1 rounded-md">QRIS</span>
                            @elseif($trx->payment_method === 'cash')
                                <span class="bg-orange-50 text-orange-600 text-xs font-bold px-2.5 py-1 rounded-md">Tunai</span>
                            @endif
                        </td>

                        <td class="px-5 py-4 text-right font-bold text-gray-800 align-middle">
                            Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                        </td>

                        <td class="px-5 py-4 text-center align-middle">
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('admin.transactions.verify', $trx->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        onclick="return confirm('Verifikasi pembayaran ini sudah diterima?')"
                                        class="inline-flex items-center gap-1.5 border border-emerald-200
                                        bg-emerald-50 hover:bg-emerald-500 text-emerald-600 hover:text-white
                                        active:scale-95 px-3.5 py-2 rounded-lg text-xs font-medium transition" title="Verifikasi">
                                        <i class="fa-solid fa-check text-[10px]"></i> Verifikasi
                                    </button>
                                </form>
                                <form action="{{ route('admin.transactions.reject', $trx->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        onclick="return confirm('Yakin ingin menolak pembayaran ini? Stok produk akan dikembalikan.')"
                                        class="inline-flex items-center gap-1.5 border border-red-200
                                        bg-red-50 hover:bg-red-500 text-red-600 hover:text-white
                                        active:scale-95 px-3.5 py-2 rounded-lg text-xs font-medium transition" title="Tolak">
                                        <i class="fa-solid fa-xmark text-[10px]"></i> Tolak
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
                                    <i class="fa-solid fa-check-double text-2xl text-gray-300"></i>
                                </div>
                                <p class="text-sm font-medium">Tidak ada transaksi tertunda.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
