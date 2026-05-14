<?php

namespace App\Http\Controllers;
// use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Transaction;
// use App\Models\TransactionItem;
// use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Default: bulan ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date',   Carbon::now()->endOfMonth()->format('Y-m-d'));
        $search    = $request->input('search', '');

        $start = Carbon::parse($startDate)->startOfDay();
        $end   = Carbon::parse($endDate)->endOfDay();

        // Ambil transaksi dengan filter tanggal
        $query = Transaction::with(['user', 'items.product'])
            ->whereBetween('created_at', [$start, $end])
            ->where('status', 'selesai');

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $transactions = $query->latest()->paginate(15)->withQueryString();

        // Ringkasan statistik
        $totalPendapatan = Transaction::whereBetween('created_at', [$start, $end])->where('status', 'selesai')->sum('total_price');
        $totalTransaksi  = Transaction::whereBetween('created_at', [$start, $end])->where('status', 'selesai')->count();
        $rataRata        = $totalTransaksi > 0 ? round($totalPendapatan / $totalTransaksi) : 0;

        // Produk terlaris di periode ini
        $produkTerlaris = TransactionItem::select('product_id', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->whereHas('transaction', function ($q) use ($start, $end) {
                $q->whereBetween('created_at', [$start, $end])->where('status', 'selesai');
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Data chart harian
        $chartData = Transaction::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total_price) as total'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->whereBetween('created_at', [$start, $end])
            ->where('status', 'selesai')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $chartLabels = $chartData->pluck('tanggal')->map(fn($d) => Carbon::parse($d)->format('d M'));
        $chartTotals = $chartData->pluck('total');
        $chartCount  = $chartData->pluck('jumlah');

        return view('laporan.index', compact(
            'transactions',
            'totalPendapatan',
            'totalTransaksi',
            'rataRata',
            'produkTerlaris',
            'chartLabels',
            'chartTotals',
            'chartCount',
            'startDate',
            'endDate',
            'search'
        ));
    }

    public function detail($id)
    {
        $transaction = Transaction::with(['user', 'items.product'])->findOrFail($id);
        return view('laporan.detail', compact('transaction'));
    }

    public function print($id)
    {
        $transaction = Transaction::with(['user', 'items.product'])->findOrFail($id);
        return view('laporan.print', compact('transaction'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
