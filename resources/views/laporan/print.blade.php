<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi #{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #f3f4f6;
            display: flex;
            justify-content: center;
            padding: 2rem;
        }
        .receipt {
            background: white;
            width: 340px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .receipt-header {
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            color: white;
            text-align: center;
            padding: 24px 20px;
        }
        .receipt-header .brand {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 4px;
        }
        .receipt-header .subtitle {
            font-size: 11px;
            opacity: 0.75;
            letter-spacing: 1px;
        }
        .receipt-header .trx-id {
            margin-top: 14px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            padding: 8px 16px;
            display: inline-block;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 1px;
        }

        .receipt-body { padding: 20px; }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
            font-size: 12px;
        }
        .info-row .label { color: #9ca3af; }
        .info-row .value { font-weight: 600; color: #374151; text-align: right; max-width: 60%; }

        .divider {
            border: none;
            border-top: 1px dashed #e5e7eb;
            margin: 14px 0;
        }

        .section-title {
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .item-row {
            margin-bottom: 10px;
        }
        .item-name {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
        }
        .item-detail {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #6b7280;
            margin-top: 2px;
        }
        .item-subtotal { font-weight: 600; color: #0ea5e9; }

        .total-box {
            background: linear-gradient(135deg, #f0f9ff, #dbeafe);
            border-radius: 12px;
            padding: 14px;
            text-align: center;
            margin: 14px 0;
        }
        .total-label { font-size: 11px; color: #6b7280; margin-bottom: 4px; }
        .total-amount { font-size: 22px; font-weight: 700; color: #0ea5e9; }

        .receipt-footer {
            text-align: center;
            padding: 0 20px 20px;
        }
        .receipt-footer p {
            font-size: 11px;
            color: #9ca3af;
            margin-bottom: 3px;
        }

        .barcode-placeholder {
            display: flex;
            justify-content: center;
            margin: 10px 0;
        }
        .barcode-placeholder svg { opacity: 0.3; }

        @media print {
            body {
                background: white;
                padding: 0;
                display: block;
            }
            .receipt {
                box-shadow: none;
                border-radius: 0;
                width: 100%;
                max-width: 300px;
                margin: 0 auto;
            }
            .print-btn { display: none; }
        }
    </style>
</head>
<body>
    <div>
        <div class="receipt">
            <div class="receipt-header">
                <div class="brand"> KOPERASIKU</div>
                <div class="subtitle">KOPERASI SEKOLAH</div>
                <div class="trx-id">TRX #{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</div>
            </div>

            <div class="receipt-body">
                <div class="info-row">
                    <span class="label">Tanggal</span>
                    <span class="value">{{ $transaction->created_at->format('d M Y, H:i') }} WIB</span>
                </div>
                <div class="info-row">
                    <span class="label">Pembeli</span>
                    <span class="value">{{ $transaction->user->name ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Kasir</span>
                    <span class="value">Administrator</span>
                </div>

                <hr class="divider">

                <div class="section-title">Detail Pembelian</div>

                @foreach($transaction->items as $item)
                <div class="item-row">
                    <div class="item-name">{{ $item->product->name ?? '-' }}</div>
                    <div class="item-detail">
                        <span>{{ $item->qty }} pcs × Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        <span class="item-subtotal">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach

                <hr class="divider">

                <div class="total-box">
                    <div class="total-label">TOTAL PEMBAYARAN</div>
                    <div class="total-amount">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="receipt-footer">
                <div class="barcode-placeholder">
                    <svg width="120" height="40" viewBox="0 0 120 40">
                        @for($i = 0; $i < 30; $i++)
                            <rect x="{{ $i * 4 }}" y="0" width="{{ rand(1,3) }}" height="{{ rand(20, 40) }}" fill="#374151"/>
                        @endfor
                    </svg>
                </div>
                <p>Terima kasih telah berbelanja!</p>
                <p>Simpan struk ini sebagai bukti pembelian</p>
                <p style="margin-top: 8px; font-size: 10px;">{{ now()->format('d/m/Y H:i:s') }}</p>
            </div>
        </div>

        <div style="text-align: center; margin-top: 20px;" class="print-btn">
            <button onclick="window.print()"
                style="background: linear-gradient(135deg, #0ea5e9, #2563eb); color: white; border: none;
                       padding: 10px 28px; border-radius: 12px; font-family: 'Poppins', sans-serif;
                       font-size: 14px; font-weight: 600; cursor: pointer;">
                 Cetak Struk
            </button>
            <button onclick="window.close()"
                style="background: #f3f4f6; color: #6b7280; border: none; margin-left: 10px;
                       padding: 10px 20px; border-radius: 12px; font-family: 'Poppins', sans-serif;
                       font-size: 14px; font-weight: 600; cursor: pointer;">
                ✕ Tutup
            </button>
        </div>
    </div>
</body>
</html>
