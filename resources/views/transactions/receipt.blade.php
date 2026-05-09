<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran KoperasiKU - #{{ $transaction->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            body { background: white; }
            .no-print { display: none !important; }
            .receipt-container { box-shadow: none !important; border: none !important; margin: 0 !important; width: 100% !important; max-width: 100% !important; }
        }
        .receipt-body {
            font-family: 'Courier Prime', monospace;
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex flex-col items-center py-10 px-4 font-['Inter'] selection:bg-sky-200">

    <div class="mb-6 flex gap-3 w-full max-w-md justify-center no-print fade-in-up">
        <button onclick="window.print()" class="px-5 py-2.5 bg-sky-500 hover:bg-sky-600 text-white rounded-xl shadow-lg shadow-sky-500/30 transition transform hover:-translate-y-0.5 active:scale-95 font-semibold flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Cetak Bukti
        </button>
        <a href="{{ route('siswa.dashboard') }}" class="px-5 py-2.5 bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 rounded-xl shadow-sm transition transform hover:-translate-y-0.5 active:scale-95 font-semibold flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Receipt Card -->
    <div class="receipt-container w-full max-w-md bg-white p-8 rounded-tr-3xl rounded-bl-3xl rounded-tl-md rounded-br-md shadow-xl border border-slate-100 relative overflow-hidden">

        <!-- Decorative Header -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-sky-400 via-indigo-500 to-sky-400"></div>

        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-br from-sky-400 to-indigo-600 rounded-2xl mx-auto flex items-center justify-center shadow-lg shadow-sky-500/20 mb-4 transform rotate-3">
                <i class="fa-solid fa-store text-white text-2xl -rotate-3"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">KOPERASIKU</h1>
            <p class="text-sm text-slate-500 font-medium">Koperasi Sekolah Masa Kini</p>
        </div>

        <div class="border-t-2 border-dashed border-slate-200 py-4 mb-4 receipt-body text-sm text-slate-600 space-y-1">
            <div class="flex justify-between">
                <span>No. Transaksi</span>
                <span class="font-bold text-slate-800">#TRX-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal</span>
                <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Siswa</span>
                <span>{{ $transaction->user->name }}</span>
            </div>
        </div>

        <div class="mb-4">
            <table class="w-full text-sm receipt-body">
                <thead>
                    <tr class="border-b-2 border-dashed border-slate-200 text-slate-500 text-left">
                        <th class="py-2 font-normal">Item</th>
                        <th class="py-2 font-normal text-center">Qty</th>
                        <th class="py-2 font-normal text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="text-slate-700 divide-y divide-dashed divide-slate-100">
                    @foreach($transaction->items as $item)
                    <tr>
                        <td class="py-3">
                            <div class="font-medium text-slate-800">{{ $item->product->name ?? 'Produk' }}</div>
                            <div class="text-xs text-slate-400">@ Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        </td>
                        <td class="py-3 text-center">{{ $item->qty }}</td>
                        <td class="py-3 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="border-t-2 border-dashed border-slate-200 pt-4 receipt-body">
            <div class="flex justify-between items-center text-base mb-1">
                <span class="font-bold text-slate-700">TOTAL</span>
                <span class="font-bold text-xl text-sky-600 flex items-center gap-1">
                    <span class="text-sm">Rp</span> {{ number_format($transaction->total_price, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div class="mt-8 text-center bg-slate-50 py-4 rounded-xl border border-slate-100">
            <i class="fa-solid fa-qrcode text-4xl text-slate-300 mb-2"></i>
            <p class="text-xs text-slate-500 font-medium">Terima kasih atas pembelian Anda!</p>
        </div>

    </div>

</body>
</html>
