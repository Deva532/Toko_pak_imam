@extends('layouts.admin')

@section('title', "Kelola Pesanan {$order->order_number} | Admin Toko Pak Imam")
@section('page_header', "Detail Pesanan: {$order->order_number}")

@section('content')
<div class="space-y-6">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- LEFT: ITEMS & ADDRESS -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- ADDRESS & CUSTOMER INFO -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm text-xs space-y-2">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Informasi Penerima & Alamat</h3>
                <p class="font-extrabold text-sm text-slate-900">{{ $order->recipient_name }} ({{ $order->phone }})</p>
                <p class="text-slate-600 leading-relaxed">{{ $order->address_text }}</p>
                @if($order->notes)
                <p class="text-amber-700 bg-amber-50 p-2.5 rounded-xl border border-amber-200 mt-2"><i class="fa-regular fa-note-sticky mr-1"></i> Catatan: {{ $order->notes }}</p>
                @endif
            </div>

            <!-- PRODUCT ITEMS LIST -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Daftar Produk Diorder</h3>
                <div class="divide-y divide-slate-100 text-xs">
                    @foreach($order->items as $item)
                    <div class="py-3 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $item->product ? $item->product->main_image : 'https://placehold.co/100x100?text=Produk' }}" class="w-12 h-12 object-cover rounded-xl border border-slate-200 flex-shrink-0">
                            <div>
                                <h4 class="font-bold text-slate-900">{{ $item->product_name }}</h4>
                                <p class="text-[11px] text-slate-500">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <span class="font-black text-slate-900">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- RIGHT: STATUS UPDATER & PAYMENT INFO -->
        <div class="space-y-6">
            
            <!-- UPDATE STATUS FORM -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4 text-xs">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Update Status & Nomor Resi</h3>

                <form method="POST" action="{{ route('admin.orders.update_status', $order->id) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Status Pesanan saat ini</label>
                        <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 font-bold focus:ring-2 focus:ring-green-500 focus:outline-none">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                            <option value="waiting_payment" {{ $order->status === 'waiting_payment' ? 'selected' : '' }}>Belum Dibayar</option>
                            <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Sudah Dibayar (Lunas)</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses / Dikemas</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Dikirim (Dalam Pengiriman)</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai (Diterima)</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Kurir</label>
                        <input type="text" name="courier_name" value="{{ old('courier_name', $order->courier_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nomor Resi Pengiriman</label>
                        <input type="text" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="Contoh: TPI-RESI-98123" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 font-mono focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl shadow-md transition">
                        Update Status Pesanan
                    </button>
                </form>

                <div class="pt-3 border-t border-slate-100">
                    <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-print"></i> Cetak Invoice Pesanan
                    </a>
                </div>
            </div>

            <!-- PAYMENT PROOF INSPECTION -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm text-xs space-y-3">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Bukti Pembayaran</h3>
                @if($order->payment && $order->payment->proof_image)
                <div class="rounded-xl overflow-hidden border border-slate-200">
                    <img src="{{ asset('storage/' . $order->payment->proof_image) }}" class="w-full h-auto">
                </div>
                @else
                <p class="text-slate-500 italic">Belum ada bukti pembayaran diunggah.</p>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection
