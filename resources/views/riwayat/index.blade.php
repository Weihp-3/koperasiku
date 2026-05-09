@extends('layouts.master')
@section('title', 'Riwayat Pembelian')
@section('header', 'Riwayat Pembelian')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h2 class="text-lg font-bold text-gray-800">Riwayat Pembelian</h2>
        <p class="text-xs text-gray-400 mt-0.5">Semua transaksi pembelian kamu</p>
    </div>
    <div class="flex items-center gap-2 bg-sky-50 border border-sky-100 rounded-xl px-4 py-3">
        {{-- <i class="fa-solid fa-receipt text-sky-400 text-sm"></i> --}}
        <div>
            <p class="text-xs text-gray-400">Total Pembelian</p>
            <p class="text-sm font-bold text-sky-500">
                Rp {{ number_format($riwayat->sum('total_price'), 0, ',', '.') }}
            </p>
        </div>
    </div>
</div>
@if($riwayat->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-bag-shopping text-2xl text-gray-300"></i>
        </div>
        <p class="font-medium text-gray-500 text-sm">Belum ada riwayat pembelian</p>
        <p class="text-xs text-gray-400 mt-1 mb-4">Yuk mulai belanja di koperasi!</p>
        <a href="{{ route('pembelian.index') }}"
            class="inline-flex items-center gap-2 bg-sky-400 hover:bg-sky-500 active:scale-95
            text-white px-5 py-2.5 rounded-xl text-sm font-medium transition shadow-sm">
            <i class="fa-solid fa-cart-shopping text-xs"></i> Mulai Belanja
        </a>
    </div>
@else
    <div class="space-y-4">
        @foreach($riwayat as $trx)
            <div id="trx-{{ $trx->id }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden transition">

                {{-- HEADER TRANSAKSI --}}
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-sky-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-receipt text-sky-400 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">
                                Pembelian #{{ $trx->id }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $trx->created_at->format('d F Y') }} ·
                                {{ $trx->created_at->format('H:i') }} WIB
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-sky-500">
                            Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                        </p>
                        <span class="inline-flex items-center gap-1 bg-green-50 text-green-600
                            text-xs font-medium px-2.5 py-0.5 rounded-full mt-1">
                            <i class="fa-solid fa-circle-check text-xs"></i> Selesai
                        </span>
                    </div>
                </div>

                {{-- ITEM LIST --}}
                <div class="px-5 py-4">
                    <div class="space-y-3">
                        @foreach($trx->items as $item)
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gray-50 rounded-xl border border-gray-100
                                    flex items-center justify-center overflow-hidden flex-shrink-0">
                                    <img
                                        src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : asset('images/default.png') }}"
                                        alt="{{ $item->product->name ?? '-' }}"
                                        style="max-width: 40px; max-height: 40px; object-fit: contain;"
                                    >
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate">
                                        {{ $item->product->name ?? 'Produk dihapus' }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        {{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-sm font-bold text-gray-800">
                                        Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- TOTAL PER TRANSAKSI --}}
                    <div class="flex justify-between items-center mt-4 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-400">
                            {{ $trx->items->count() }} item
                        </span>
                        <div class="flex items-center gap-1.5 text-sm">
                            <span class="text-gray-500">Total:</span>
                            <span class="font-bold text-gray-800">
                                Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
{{-- <script>
function hapusTransaksi(id, el) {
    if (!confirm('Yakin mau hapus transaksi ini?')) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/riwayat/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': token
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {

            const card = document.getElementById(`trx-${id}`);
            card.style.transition = '0.3s';
            card.style.opacity = '0';
            card.style.transform = 'translateX(50px)';

            setTimeout(() => {
                card.remove();
            }, 300);

        }
    })
    .catch(() => alert('Gagal hapus data'));
}
</script> --}}
