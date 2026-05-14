<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items'        => 'required|array',
            'items.*.id'   => 'required|exists:products,id',
            'items.*.qty'    => 'required|integer|min:1',
            'total_price'    => 'required|numeric',
            'payment_method' => 'required|in:saldo,qris,cash',
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail(Auth::id());
            $paymentMethod = $request->payment_method ?? 'saldo';
            $status = $paymentMethod === 'saldo' ? 'selesai' : 'pending';

            // Jika user adalah siswa dan bayar pakai saldo, cek dan potong saldo
            if ($user->role === 'siswa' && $paymentMethod === 'saldo') {
                if ($user->balance < $request->total_price) {
                    return response()->json([
                        'success' => false,
                        'message' => "Saldo tidak mencukupi! Saldo Anda: Rp " . number_format($user->balance, 0, ',', '.')
                    ], 422);
                }
            }

            // Cek stok semua item dulu
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['id']);
                if ($product->stock < $item['qty']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok {$product->name} tidak mencukupi!"
                    ], 422);
                }
            }

            // Buat transaksi SEKALI di luar loop
            $transaction = Transaction::create([
                'user_id'        => $user->id,
                'total_price'    => $request->total_price,
                'payment_method' => $paymentMethod,
                'status'         => $status,
            ]);

            // Simpan item & kurangi stok
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['id']);

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $product->id,
                    'qty'            => $item['qty'],
                    'price'          => $product->price,
                    'subtotal'       => $product->price * $item['qty'],
                ]);

                $product->decrement('stock', $item['qty']);
            }

            // Potong balance jika role siswa dan metode pembayaran saldo
            if ($user->role === 'siswa' && $paymentMethod === 'saldo') {
                $user->balance -= $request->total_price;
                $user->save();
            }

            DB::commit();

            return response()->json([
                'success'        => true,
                'message'        => 'Transaksi berhasil!',
                'transaction_id' => $transaction->id,
                'total_price'    => $request->total_price,
                'current_balance'=> $user->balance, // kirim balik balance
                'receipt_url'    => route('transactions.receipt', $transaction->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal membuat transaksi', [
                'error_message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display pending transactions for admin.
     */
    public function pending()
    {
        $transactions = Transaction::with(['user', 'items.product'])
            ->where('status', 'pending')
            ->latest()
            ->get();
            
        return view('admin.transactions.pending', compact('transactions'));
    }

    /**
     * Verify a pending transaction.
     */
    public function verify($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'selesai']);
        return redirect()->back()->with('success', 'Transaksi berhasil diverifikasi.');
    }

    /**
     * Reject a pending transaction and restore stock.
     */
    public function reject($id)
    {
        $transaction = Transaction::with('items.product')->findOrFail($id);
        
        $transaction->update(['status' => 'batal']);
        
        // Kembalikan stok
        foreach ($transaction->items as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->qty);
            }
        }

        return redirect()->back()->with('success', 'Transaksi pembayaran berhasil ditolak dan stok dikembalikan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Display the receipt for the specified transaction.
     */
    public function receipt(string $id)
    {
        // Find transaction and its items
        $transaction = Transaction::with(['items.product', 'user'])->findOrFail($id);

        // Ensure user can only see their own receipt (or if admin, maybe can see all, but here we secure for user)
        if (Auth::user()->role === 'siswa' && $transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this receipt.');
        }

        return view('transactions.receipt', compact('transaction'));
    }
}
