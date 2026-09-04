@extends('layouts.app')

@section('title', "Detail Pesanan {$order->order_number} | Toko Pak Imam")

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ uploadModal: false }">
    
    <!-- HEADER & STATUS -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <nav class="flex text-xs text-gray-500 mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1">
                    <li><a href="{{ route('orders.index') }}" class="hover:text-brand-600">Pesanan Saya</a></li>
                    <li><i class="fa-solid fa-chevron-right text-[9px] mx-1 text-gray-400"></i></li>
                    <li class="font-bold text-gray-900">{{ $order->order_number }}</li>
                </ol>
            </nav>
            <h1 class="text-xl sm:text-2xl font-black text-gray-900">Detail Pesanan: {{ $order->order_number }}</h1>
        </div>

        <div class="flex items-center gap-3">
            <span class="inline-block px-4 py-1.5 rounded-full font-extrabold text-xs border {{ $order->status_badge['class'] }}">
                Status: {{ $order->status_badge['label'] }}
            </span>
            <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="px-4 py-2 rounded-xl bg-gray-900 hover:bg-gray-800 text-white text-xs font-bold transition">
                <i class="fa-solid fa-print mr-1"></i> Cetak Invoice
            </a>
        </div>
    </div>

    <!-- TRACKING STATUS STEPPER -->
    <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm mb-8">
        <h3 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider mb-6">Status Pengiriman Pesanan</h3>

        <div class="grid grid-cols-5 gap-2 text-center text-xs relative">
            
            <!-- Step 1: Menunggu / Order Made -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold mb-2 shadow-sm {{ in_array($order->status, ['pending', 'waiting_payment', 'paid', 'processing', 'shipped', 'completed']) ? 'bg-brand-600 text-white' : 'bg-gray-100 text-gray-400' }}">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <span class="font-bold text-gray-900">Pesanan Dibuat</span>
                <span class="text-[10px] text-gray-400 mt-0.5">{{ $order->created_at->format('H:i, d M') }}</span>
            </div>

            <!-- Step 2: Pembayaran -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold mb-2 shadow-sm {{ in_array($order->status, ['paid', 'processing', 'shipped', 'completed']) ? 'bg-brand-600 text-white' : 'bg-gray-100 text-gray-400' }}">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <span class="font-bold text-gray-900">Terbayar</span>
                <span class="text-[10px] text-gray-400 mt-0.5">Toko Pak Imam</span>
            </div>

            <!-- Step 3: Diproses -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold mb-2 shadow-sm {{ in_array($order->status, ['processing', 'shipped', 'completed']) ? 'bg-brand-600 text-white' : 'bg-gray-100 text-gray-400' }}">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <span class="font-bold text-gray-900">Dikemas</span>
                <span class="text-[10px] text-gray-400 mt-0.5">Penyiapan Stok</span>
            </div>

            <!-- Step 4: Dikirim -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold mb-2 shadow-sm {{ in_array($order->status, ['shipped', 'completed']) ? 'bg-brand-600 text-white' : 'bg-gray-100 text-gray-400' }}">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <span class="font-bold text-gray-900">Dalam Pengiriman</span>
                <span class="text-[10px] text-gray-400 mt-0.5">{{ $order->courier_name }}</span>
            </div>

            <!-- Step 5: Selesai -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold mb-2 shadow-sm {{ $order->status === 'completed' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-400' }}">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <span class="font-bold text-gray-900">Pesanan Selesai</span>
                <span class="text-[10px] text-gray-400 mt-0.5">Diterima</span>
            </div>
        </div>

        @if($order->tracking_number)
        <div class="mt-6 pt-4 border-t border-gray-100 bg-brand-50 p-4 rounded-2xl flex items-center justify-between text-xs text-brand-900">
            <div>
                <span class="font-bold"><i class="fa-solid fa-truck-ramp-box mr-1"></i> Nomor Resi Kurir:</span>
                <span class="font-mono font-black text-sm ml-2 text-brand-700">{{ $order->tracking_number }}</span>
            </div>
            <span class="text-[11px] font-semibold text-brand-600">Kurir: {{ $order->courier_name }}</span>
        </div>
        @endif
    </div>

    <!-- MAIN DETAILS GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- LEFT: ITEMS & ADDRESS -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- ADDRESS CARD -->
            <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                <h3 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider mb-3">Alamat Tujuan Pengiriman</h3>
                <div class="text-xs text-gray-700 space-y-1">
                    <p class="font-extrabold text-sm text-gray-900">{{ $order->recipient_name }} ({{ $order->phone }})</p>
                    <p class="leading-relaxed">{{ $order->address_text }}</p>
                    @if($order->notes)
                    <p class="text-[11px] text-gray-500 italic mt-2"><i class="fa-regular fa-note-sticky mr-1"></i> Catatan: {{ $order->notes }}</p>
                    @endif
                </div>
            </div>

            <!-- PRODUCT ITEMS LIST -->
            <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                <h3 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider mb-4">Daftar Produk Dibeli</h3>
                <div class="divide-y divide-gray-100">
                    @foreach($order->items as $item)
                    <div class="py-3 flex items-center gap-4">
                        <img src="{{ $item->product ? $item->product->main_image : 'https://placehold.co/100x100?text=Produk' }}" class="w-14 h-14 object-cover rounded-xl border border-gray-100 flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-gray-900 truncate">{{ $item->product_name }}</h4>
                            <p class="text-[11px] text-gray-500 mt-0.5">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <span class="text-xs font-extrabold text-gray-900">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- RIGHT: PAYMENT & SUMMARY -->
        <div class="space-y-6">
            
            <!-- PAYMENT INSTRUCTIONS CARD -->
            <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                <h3 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider mb-4">Info Pembayaran</h3>

                <div class="text-xs space-y-3 mb-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">Metode:</span>
                        <span class="font-bold text-gray-900 uppercase">{{ $order->payment ? $order->payment->payment_method : 'COD' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">Status Bayar:</span>
                        <span class="font-bold uppercase {{ $order->payment && $order->payment->payment_status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ $order->payment ? $order->payment->payment_status : 'Unpaid' }}
                        </span>
                    </div>
                </div>

                <!-- BANK INSTRUCTIONS IF WAITING PAYMENT -->
                @if($order->status === 'waiting_payment')
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 text-xs text-blue-900 space-y-2 mb-4">
                    <p class="font-bold"><i class="fa-solid fa-building-columns text-blue-600 mr-1"></i> Transfer Bank Toko Pak Imam:</p>
                    <div class="font-mono bg-white p-2.5 rounded-xl border border-blue-100">
                        <p class="font-bold">BCA: 8829-1029-3881</p>
                        <p class="text-[11px] text-gray-600">a.n Toko Pak Imam</p>
                    </div>
                    <button @click="uploadModal = true" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-2.5 rounded-xl shadow-sm transition mt-2">
                        <i class="fa-solid fa-upload mr-1"></i> Unggah Bukti Transfer
                    </button>
                </div>
                @endif

                <!-- CANCEL ORDER BUTTON -->
                @if(in_array($order->status, ['pending', 'waiting_payment']))
                <form method="POST" action="{{ route('orders.cancel', $order->id) }}" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                    @csrf
                    <button type="submit" class="w-full bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs py-2.5 rounded-xl transition">
                        <i class="fa-solid fa-ban mr-1"></i> Batalkan Pesanan
                    </button>
                </form>
                @endif
            </div>

            <!-- PAYMENT SUMMARY -->
            <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-3 text-xs">
                <h3 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider mb-2">Rincian Pembayaran</h3>

                <div class="flex items-center justify-between text-gray-600">
                    <span>Subtotal Produk</span>
                    <span class="font-bold text-gray-900">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between text-gray-600">
                    <span>Ongkos Kirim ({{ $order->courier_name }})</span>
                    <span class="font-bold text-gray-900">Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                @if($order->discount_amount > 0)
                <div class="flex items-center justify-between text-emerald-600">
                    <span>Diskon Voucher</span>
                    <span class="font-bold">-Rp{{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                </div>
                @endif

                <div class="border-t border-gray-100 pt-3 flex items-center justify-between text-sm font-extrabold text-gray-900">
                    <span>Total Akhir</span>
                    <span class="text-lg text-brand-600">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

        </div>
    </div>

    <!-- PROOF UPLOAD MODAL -->
    <div x-show="uploadModal" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="text-sm font-extrabold text-gray-900">Unggah Bukti Pembayaran</h3>
                <button @click="uploadModal = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form method="POST" action="{{ route('orders.upload_proof', $order->id) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Pilih Foto / Struk Transfer (Max 2MB)</label>
                    <input type="file" name="proof_image" accept="image/*" required class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" @click="uploadModal = false" class="px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-100 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold bg-brand-600 hover:bg-brand-700 text-white rounded-xl shadow-md transition">Kirim Bukti</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
