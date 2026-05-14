@extends('layouts.master')
@section('title', 'Pembelian')
@section('header', 'Pembelian Koperasi')
@section('content')
<div class="flex flex-col lg:flex-row gap-4">
    <div class="flex-1 flex flex-col">
        <div class="relative mb-4">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input
                type="text"
                id="searchInput"
                placeholder="Cari produk..."
                onkeyup="filterProduk()"
                class="w-full border rounded-lg pl-9 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-400">
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="productGrid">
            @forelse ($products as $product)
                <div class="product-card bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition duration-200 overflow-hidden flex flex-col"
                    data-name="{{ strtolower($product->name) }}">
                    <div class="h-44 bg-white flex items-center justify-center p-4 border-b border-gray-100">
                        <img
                            src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default.png') }}"
                            alt="{{ $product->name }}"
                            style="max-height: 140px; max-width: 100%; object-fit: contain;"
                        >
                    </div>
                    <div class="p-3 flex flex-col flex-1">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $product->name }}</p>
                        <p class="text-sky-500 text-sm mt-0.5 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-gray-400 text-xs mt-0.5">Stok: {{ $product->stock }}</p>
                        <button
                            onclick="tambahKeKeranjang({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock }}, '{{ $product->image ? asset('storage/' . $product->image) : asset('images/default.png') }}')"
                            class="mt-auto pt-2 w-full bg-sky-400 hover:bg-sky-500 active:scale-95 text-white text-sm py-2 rounded-lg transition duration-150 flex items-center justify-center gap-1
                            {{ $product->stock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $product->stock == 0 ? 'disabled' : '' }}>
                            <i class="fa-solid fa-plus text-xs"></i> Beli
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-12 text-gray-400">
                    <i class="fa-solid fa-box-open text-4xl mb-3 block"></i>
                    Belum ada produk.
                </div>
            @endforelse
        </div>
        <div class="mt-4 text-xs text-gray-500">
            {{ $products->links() }}
        </div>
    </div>

    <div class="w-full lg:w-72 flex-shrink-0 flex flex-col bg-white rounded-xl shadow border border-gray-200" style="max-height: calc(100vh - 120px);">
        <div class="flex flex-col px-4 py-3 border-b bg-slate-50 rounded-t-xl">
            <div class="flex items-center justify-between mb-1">
                <div class="flex items-center gap-2 text-gray-700 font-bold text-sm">
                    <i class="fa-solid fa-cart-shopping text-sky-500"></i>
                    Keranjang
                </div>
                <button onclick="hapusSemua()"
                    class="text-xs text-red-500 hover:text-red-600 font-medium flex items-center gap-1 transition">
                    <i class="fa-solid fa-trash text-xs"></i> Kosongkan
                </button>
            </div>
            <div class="text-[11px] text-gray-500 mt-2 p-2 bg-white rounded border flex justify-between items-center">
                <span>Saldo Anda:</span>
                <span class="font-bold text-sky-600">Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto px-3 py-2" id="keranjangList">
            <div id="keranjangKosong" class="flex flex-col items-center justify-center h-40 text-gray-300">
                <i class="fa-solid fa-cart-shopping text-4xl mb-2"></i>
                <p class="text-xs">Keranjang kosong</p>
            </div>
        </div>

        <div class="border-t px-4 py-4 bg-slate-50 rounded-b-xl">
            <div class="mb-3">
                <label class="text-xs text-gray-600 font-semibold block mb-1">Metode Pembayaran</label>
                <select id="paymentMethod" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-400" onchange="renderKeranjang()">
                    <option value="saldo">Saldo Koperasi</option>
                    <option value="qris">QRIS</option>
                    <option value="cash">Tunai / Cash</option>
                </select>
            </div>
            <div class="flex justify-between items-center mb-3">
                <span class="text-sm text-gray-600 font-semibold">Total Diminta</span>
                <span class="text-lg font-bold text-gray-800" id="totalHarga">Rp 0</span>
            </div>
            <button onclick="prosesTransaksi()"
                id="btnBayar"
                class="w-full bg-sky-500 hover:bg-sky-600 active:scale-95 text-white py-3 rounded-xl text-sm font-bold transition duration-150 shadow-md shadow-sky-500/30">
                Bayar dengan Saldo
            </button>
        </div>
    </div>

    <!-- Modal Konfirmasi / Sukses -->
    <div id="modalBayar" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 items-center justify-center transition-all duration-300 opacity-0 flex">
        <div class="bg-white w-[400px] rounded-2xl p-6 shadow-xl transform scale-95 transition-all duration-300" id="modalCard">
            <!-- State KONFIRMASI -->
            <div id="stateKonfirmasi">
                <div class="flex justify-between items-center mb-4 border-b pb-3">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-wallet text-sky-500"></i> Konfirmasi Bayar
                    </h2>
                    <button onclick="tutupModal()" class="text-slate-400 hover:text-red-500">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <div class="bg-slate-50 rounded-xl p-4 mb-4 border border-slate-100 flex justify-between items-center">
                    <span class="text-sm font-semibold text-slate-500">Total Tagihan</span>
                    <span id="modalTotal" class="text-xl font-bold text-sky-600">Rp 0</span>
                </div>

                <div class="flex justify-between items-center text-sm mb-6 px-1">
                    <span class="text-slate-500">Sisa Saldo Setelah Beli:</span>
                    <span id="sisaSaldo" class="font-bold text-slate-700">Rp 0</span>
                </div>

                <button
                    onclick="konfirmasiBayar()"
                    id="btnProcessConfirm"
                    class="w-full bg-sky-500 hover:bg-sky-600 text-white py-3 rounded-xl font-bold shadow-md shadow-sky-500/30">
                    Proses Sekarang
                </button>
            </div>
            <div id="stateSukses" class="hidden">
                <div class="flex flex-col items-center pb-2">
                    <div id="successIconWrapper" class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center mb-4 animate-bounce">
                        <i id="successIcon" class="fa-solid fa-check text-emerald-500 text-3xl"></i>
                    </div>
                    <h2 id="successTitle" class="text-xl font-bold text-slate-800">Pembelian Berhasil!</h2>
                    <p id="successDesc" class="text-sm text-slate-500 mt-1">Saldo Anda telah dipotong</p>
                </div>

                <div id="qrisContainer" class="hidden flex-col items-center mt-4">
                    <div class="bg-white p-3 rounded-2xl shadow-sm border border-slate-200">
                        <!-- Anda dapat mengganti src ini dengan QRIS dinamis/hasil generate nantinya -->
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/QR_Code_Example.svg/250px-QR_Code_Example.svg.png?utm_source=commons.wikimedia.org&utm_campaign=index&utm_content=thumbnail" alt="QRIS" class="w-40 h-40 object-contain">
                    </div>
                </div>

                <div class="bg-slate-50 rounded-xl p-4 my-4 text-center border border-slate-100">
                    <p class="text-xs text-slate-500 mb-1">Total</p>
                    <p id="totalSuksesInfo" class="text-2xl font-bold text-sky-600">Rp 0</p>
                </div>

                <div class="flex border-t pt-4">
                    <button onclick="tutupLanjut()"
                        class="w-full py-3 text-sm font-bold bg-slate-800 hover:bg-slate-900 shadow-md text-white transition rounded-xl">
                        Tutup & Belanja Lagi
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    const userBalance = {{ Auth::user()->balance }};
    let currentTotal = 0;
    let keranjang = [];

    function tambahKeKeranjang(id, nama, harga, stok, foto) {
        const existing = keranjang.find(item => item.id === id);
        if (existing) {
            if (existing.qty >= stok) {
                alert('Stok tidak mencukupi!');
                return;
            }
            existing.qty++;
        } else {
            keranjang.push({ id, nama, harga, qty: 1, stok, foto });
        }
        renderKeranjang();
    }

    function ubahQty(id, delta) {
        const item = keranjang.find(i => i.id === id);
        if (!item) return;
        item.qty += delta;
        if (item.qty <= 0) {
            keranjang = keranjang.filter(i => i.id !== id);
        } else if (item.qty > item.stok) {
            item.qty = item.stok;
            alert('Stok maksimum untuk produk ini!');
        }
        renderKeranjang();
    }

    function hapusSemua() {
        if (keranjang.length === 0) return;
        if (confirm('Hapus semua item dari keranjang?')) {
            keranjang = [];
            renderKeranjang();
        }
    }

    function renderKeranjang() {
        const list = document.getElementById('keranjangList');
        currentTotal = keranjang.reduce((sum, i) => sum + i.harga * i.qty, 0);
        document.getElementById('totalHarga').textContent = 'Rp ' + currentTotal.toLocaleString('id-ID');

        const paymentMethod = document.getElementById('paymentMethod').value;
        const btnBayar = document.getElementById('btnBayar');
        if(paymentMethod === 'saldo' && currentTotal > userBalance) {
            btnBayar.classList.remove('bg-sky-500', 'hover:bg-sky-600');
            btnBayar.classList.add('bg-red-500', 'hover:bg-red-600');
            btnBayar.innerHTML = 'Saldo Tidak Cukup <i class="fa-solid fa-triangle-exclamation"></i>';
        } else {
            btnBayar.classList.add('bg-sky-500', 'hover:bg-sky-600');
            btnBayar.classList.remove('bg-red-500', 'hover:bg-red-600');
            let txt = paymentMethod === 'qris' ? 'Bayar dengan QRIS' : (paymentMethod === 'cash' ? 'Bayar Tunai' : 'Bayar dengan Saldo');
            btnBayar.innerHTML = txt + ' <i class="fa-solid fa-arrow-right"></i>';
        }

        if (keranjang.length === 0) {
            list.innerHTML = `
                <div class="flex flex-col items-center justify-center h-40 text-gray-300">
                    <i class="fa-solid fa-cart-shopping text-4xl mb-2"></i>
                    <p class="text-xs">Keranjang kosong</p>
                </div>`;
            return;
        }

        list.innerHTML = keranjang.map(item => `
            <div class="flex items-center gap-2 py-2 border-b border-gray-100 last:border-0">
                <div class="w-10 h-10 rounded-lg bg-white border border-slate-100 flex items-center justify-center overflow-hidden flex-shrink-0">
                    <img src="${item.foto}" style="max-width:32px; max-height:32px; object-fit:contain;">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-slate-800 truncate">${item.nama}</p>
                    <p class="text-xs text-sky-500 font-bold">Rp ${item.harga.toLocaleString('id-ID')}</p>
                </div>
                <div class="flex items-center gap-1 flex-shrink-0 p-1 bg-slate-50 rounded-lg">
                    <button onclick="ubahQty(${item.id}, -1)" class="w-5 h-5 rounded hover:bg-slate-200 text-slate-600 text-[10px] items-center justify-center flex transition">−</button>
                    <span class="text-xs font-bold w-5 text-center px-1">${item.qty}</span>
                    <button onclick="ubahQty(${item.id}, 1)" class="w-5 h-5 rounded hover:bg-sky-500 hover:text-white bg-slate-200 text-slate-600 text-[10px] items-center justify-center flex transition">+</button>
                </div>
            </div>
        `).join('');
    }

    function filterProduk() {
        const keyword = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('.product-card').forEach(card => {
            const name = card.dataset.name;
            card.style.display = name.includes(keyword) ? '' : 'none';
        });
    }

    function prosesTransaksi() {
        if (keranjang.length === 0) {
            alert('Pilih pesanan terlebih dahulu!');
            return;
        }
        const paymentMethod = document.getElementById('paymentMethod').value;
        if (paymentMethod === 'saldo' && currentTotal > userBalance) {
            alert('Saldo Anda tidak cukup! Harap isi saldo terlebih dahulu.');
            return;
        }

        document.getElementById('modalTotal').textContent = 'Rp ' + currentTotal.toLocaleString('id-ID');
        document.getElementById('totalSuksesInfo').textContent = 'Rp ' + currentTotal.toLocaleString('id-ID');
        document.getElementById('sisaSaldo').textContent = paymentMethod === 'saldo' ? 'Rp ' + (userBalance - currentTotal).toLocaleString('id-ID') : '-';

        document.getElementById('stateKonfirmasi').classList.remove('hidden');
        document.getElementById('stateSukses').classList.add('hidden');

        const modal = document.getElementById('modalBayar');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            document.getElementById('modalCard').classList.remove('scale-95');
        }, 10);
    }

    function tutupModal() {
        const modal = document.getElementById('modalBayar');
        modal.classList.add('opacity-0');
        document.getElementById('modalCard').classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    function tutupLanjut() {
        window.location.reload();
    }

    function konfirmasiBayar() {
        const items = keranjang.map(i => ({ id: i.id, qty: i.qty }));
        const btn = document.getElementById('btnProcessConfirm');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';

        const paymentMethod = document.getElementById('paymentMethod').value;
        fetch('{{ route('transactions.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items, total_price: currentTotal, payment_method: paymentMethod })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Sembunyikan konfirmasi, arahkan ke tab sukses
                document.getElementById('stateKonfirmasi').classList.add('hidden');
                
                const successTitle = document.getElementById('successTitle');
                const successDesc = document.getElementById('successDesc');
                const successIconWrapper = document.getElementById('successIconWrapper');
                const successIcon = document.getElementById('successIcon');
                const qrisContainer = document.getElementById('qrisContainer');

                if (paymentMethod === 'saldo') {
                    successTitle.textContent = 'Pembelian Berhasil!';
                    successDesc.textContent = 'Saldo Anda telah dipotong';
                    successIconWrapper.className = 'w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center mb-4 animate-bounce';
                    successIcon.className = 'fa-solid fa-check text-emerald-500 text-3xl';
                    qrisContainer.classList.replace('flex', 'hidden');
                } else if (paymentMethod === 'qris') {
                    successTitle.textContent = 'Menunggu Pembayaran!';
                    successDesc.textContent = 'Silakan scan QRIS di bawah ini untuk membayar';
                    successIconWrapper.className = 'w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mb-4 animate-pulse';
                    successIcon.className = 'fa-solid fa-qrcode text-blue-500 text-3xl';
                    qrisContainer.classList.replace('hidden', 'flex');
                } else {
                    successTitle.textContent = 'Menunggu Pembayaran!';
                    successDesc.textContent = 'Silakan berikan uang tunai ke Kasir';
                    successIconWrapper.className = 'w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center mb-4 animate-pulse';
                    successIcon.className = 'fa-solid fa-money-bill-wave text-orange-500 text-3xl';
                    qrisContainer.classList.replace('flex', 'hidden');
                }

                document.getElementById('stateSukses').classList.remove('hidden');
                keranjang = [];
            } else {
                alert(data.message || 'Transaksi gagal.');
                btn.disabled = false;
                btn.innerHTML = 'Proses Sekarang';
                tutupModal();
            }
        })
        .catch(() => {
            alert('Terjadi kesalahan jaringan.');
            btn.disabled = false;
            btn.innerHTML = 'Proses Sekarang';
            tutupModal();
        });
    }
</script>
@endpush
