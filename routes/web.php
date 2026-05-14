<?php

use App\Models\User;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\AdminSiswaController;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

// User redirect dashboard logic based on role
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('siswa.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==========================================
// ADMIN GROUP
// ==========================================
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', function () {
        $range = request('range', '7');
        $totalProduk = Product::count();
        $stokMenipis = Product::where('stock','<',5)->count();
        $penjualanHariIni = Transaction::whereDate('created_at', now())->where('status', 'selesai')->sum('total_price');
        $penjualanBulanIni = Transaction::whereMonth('created_at', now()->month)->where('status', 'selesai')->sum('total_price');
        $produkMenipis = Product::where('stock','<',5)->take(5)->get();

        $chart = Transaction::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total_price) as total')
            )
            ->where('status', 'selesai')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $labels = $chart->pluck('tanggal')->map(function($date){
            return \Carbon\Carbon::parse($date)->format('d M');
        });
        $data = $chart->pluck('total');

        return view('dashboard.admin', compact(
            'totalProduk',
            'stokMenipis',
            'penjualanHariIni',
            'penjualanBulanIni',
            'labels',
            'data',
            'produkMenipis',
            'range'
        ));
    })->name('admin.dashboard');

    Route::resource('products', ProductController::class);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{id}', [LaporanController::class, 'detail'])->name('laporan.detail');
    Route::get('/laporan/{id}/print', [LaporanController::class, 'print'])->name('laporan.print');

    Route::get('/topup', [TopupController::class, 'index'])->name('admin.topup.index');
    Route::post('/topup', [TopupController::class, 'store'])->name('admin.topup.store');
    
    Route::get('/transactions/pending', [TransactionController::class, 'pending'])->name('admin.transactions.pending');
    Route::patch('/transactions/{id}/verify', [TransactionController::class, 'verify'])->name('admin.transactions.verify');
    Route::patch('/transactions/{id}/reject', [TransactionController::class, 'reject'])->name('admin.transactions.reject');

    Route::resource('siswa', AdminSiswaController::class)->names('admin.siswa')->except(['show']);
    });

    // ==========================================
    // SISWA GROUP
    // ==========================================
    Route::middleware(['auth', 'verified', 'role:siswa'])->group(function () {
        Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
        Route::get('/siswa/pembelian', [SiswaController::class, 'pembelian'])->name('pembelian.index');
        });

        // TRANSACTIONS (Both can access, handling logic separates behavior)
        Route::middleware('auth')->group(function () {
            Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
            Route::get('/transactions/{transaction}/receipt', [TransactionController::class, 'receipt'])->name('transactions.receipt');
            Route::resource('riwayat', RiwayatController::class);
            Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
