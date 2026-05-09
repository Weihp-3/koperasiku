@extends('layouts.master')
@section('title', 'Laporan Penjualan')
@section('header', 'Laporan Penjualan')
@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-sky-400 transition">
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-sky-400 transition">
            </div>
            <div class="flex flex-col gap-1 flex-1 min-w-[180px]">
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Cari Pembeli</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Nama pembeli..."
                    class="border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-sky-400 transition">
            </div>
            <div class="flex gap-2">
                <button type="submit"
                    class="flex items-center gap-2 bg-sky-500 hover:bg-sky-600 text-white px-5 py-2 rounded-xl text-sm font-semibold transition-all shadow-md hover:shadow-sky-200 active:scale-95">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i> Filter
                </button>
                <a href="{{ route('laporan.index') }}"
                    class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-xl text-sm font-semibold transition active:scale-95">
                    <i class="fa-solid fa-rotate-left text-xs"></i> Reset
                </a>
            </div>
        </form>
    </div>

    {{-- STATISTIK CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-sky-500 to-blue-600 rounded-2xl p-5 text-white shadow-lg shadow-sky-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sky-100 text-xs font-semibold uppercase tracking-wider mb-1">Total Pendapatan</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
                {{-- <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center"> --}}
                    <i class="fa-solid fa-money-bill-wave text-xl"></i>
                {{-- </div> --}}
            </div>
        </div>

        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-5 text-white shadow-lg shadow-emerald-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-xs font-semibold uppercase tracking-wider mb-1">Total Transaksi</p>
                    <p class="text-2xl font-bold">{{ number_format($totalTransaksi) }}</p>
                </div>
                {{-- <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center"> --}}
                    <i class="fa-solid fa-receipt text-xl"></i>
                {{-- </div> --}}
            </div>
        </div>

        <div class="bg-gradient-to-br from-violet-500 to-purple-600 rounded-2xl p-5 text-white shadow-lg shadow-violet-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-violet-100 text-xs font-semibold uppercase tracking-wider mb-1">Rata-rata / Transaksi</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($rataRata, 0, ',', '.') }}</p>
                </div>
                {{-- <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center"> --}}
                    <i class="fa-solid fa-chart-bar text-xl"></i>
                {{-- </div> --}}
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- CHART PENJUALAN --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-700 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-sky-500"></i> Grafik Penjualan Harian
                </h3>
                <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} – {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
            </div>
            <div class="relative h-60">
                <canvas id="laporanChart"></canvas>
            </div>
        </div>

        {{-- PRODUK TERLARIS --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-700 text-sm flex items-center gap-2 mb-4">
                <i class="fa-solid fa-fire text-orange-400"></i> Produk Terlaris
            </h3>
            @forelse($produkTerlaris as $index => $item)
            <div class="flex items-center gap-3 mb-3">
                <span class="w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold
                    {{ $index === 0 ? 'bg-yellow-400 text-white' : ($index === 1 ? 'bg-gray-300 text-gray-700' : ($index === 2 ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-500')) }}">
                    {{ $index + 1 }}
                </span>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-700 truncate">{{ $item->product->name ?? '-' }}</p>
                    <p class="text-xs text-gray-400">{{ number_format($item->total_qty) }} terjual</p>
                </div>
                <span class="text-xs font-semibold text-sky-600 whitespace-nowrap">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</span>
            </div>
            @empty
            <p class="text-xs text-gray-400 text-center py-6">Belum ada data</p>
            @endforelse
        </div>
    </div>

    {{-- TABEL TRANSAKSI --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-700 text-sm flex items-center gap-2">
                <i class="fa-solid fa-list-ul text-sky-500"></i> Riwayat Transaksi
            </h3>
            <span class="text-xs text-gray-400">{{ $transactions->total() }} transaksi ditemukan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="px-5 py-3 text-left font-semibold">No</th>
                        <th class="px-5 py-3 text-left font-semibold">Pembeli</th>
                        <th class="px-5 py-3 text-left font-semibold">Tanggal</th>
                        <th class="px-5 py-3 text-left font-semibold">Jumlah Item</th>
                        <th class="px-5 py-3 text-left font-semibold">Total</th>
                        <th class="px-5 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $index => $trx)
                    <tr class="hover:bg-sky-50/40 transition-colors">
                        <td class="px-5 py-3 text-gray-400">{{ $transactions->firstItem() + $index }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($trx->user->name ?? '?', 0, 1)) }}
                                </div>
                                <span class="text-gray-700 font-medium truncate max-w-[120px]">{{ $trx->user->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600">
                            <div>{{ $trx->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-400">{{ $trx->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-5 py-3">
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">
                                {{ $trx->items->count() }} item
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="font-semibold text-gray-800">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('laporan.detail', $trx->id) }}"
                                    class="inline-flex items-center gap-1 text-xs bg-sky-50 hover:bg-sky-100 text-sky-600 font-semibold px-3 py-1.5 rounded-lg transition active:scale-95">
                                    <i class="fa-solid fa-eye text-[10px]"></i> Detail
                                </a>
                                <a href="{{ route('laporan.print', $trx->id) }}" target="_blank"
                                    class="inline-flex items-center gap-1 text-xs bg-emerald-50 hover:bg-emerald-100 text-emerald-600 font-semibold px-3 py-1.5 rounded-lg transition active:scale-95">
                                    <i class="fa-solid fa-print text-[10px]"></i> Cetak
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <i class="fa-solid fa-receipt text-4xl opacity-30"></i>
                                <p class="text-sm">Tidak ada transaksi pada periode ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('laporanChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 240);
    gradient.addColorStop(0, 'rgba(14, 165, 233, 0.3)');
    gradient.addColorStop(1, 'rgba(14, 165, 233, 0)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($chartTotals) !!},
                backgroundColor: gradient,
                borderColor: 'rgb(14, 165, 233)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: {
                        callback: v => 'Rp ' + (v >= 1000 ? (v/1000)+'rb' : v),
                        font: { size: 11 }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });
</script>
@endpush
