@extends('layouts.app')

@section('title', 'Pesanan Saya | Toko Pak Imam')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-xl sm:text-2xl font-black text-gray-900 mb-6 flex items-center gap-2">
        <i class="fa-solid fa-boxes-packing text-brand-600"></i> Pesanan Saya
    </h1>

    <!-- STATUS FILTER TABS -->
    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-3 mb-6 border-b border-gray-200 text-xs font-bold">
        <a href="{{ route('orders.index') }}" class="px-4 py-2 rounded-full transition flex-shrink-0 {{ !$status ? 'bg-brand-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
            Semua Pesanan
        </a>
        <a href="{{ route('orders.index', ['status' => 'waiting_payment']) }}" class="px-4 py-2 rounded-full transition flex-shrink-0 {{ $status === 'waiting_payment' ? 'bg-brand-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
            Belum Dibayar
        </a>
        <a href="{{ route('orders.index', ['status' => 'processing']) }}" class="px-4 py-2 rounded-full transition flex-shrink-0 {{ $status === 'processing' ? 'bg-brand-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
            Diproses
        </a>
        <a href="{{ route('orders.index', ['status' => 'shipped']) }}" class="px-4 py-2 rounded-full transition flex-shrink-0 {{ $status === 'shipped' ? 'bg-brand-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
            Dikirim
        </a>
        <a href="{{ route('orders.index', ['status' => 'completed']) }}" class="px-4 py-2 rounded-full transition flex-shrink-0 {{ $status === 'completed' ? 'bg-brand-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
            Selesai
        </a>
        <a href="{{ route('orders.index', ['status' => 'cancelled']) }}" class="px-4 py-2 rounded-full transition flex-shrink-0 {{ $status === 'cancelled' ? 'bg-brand-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
            Dibatalkan
        </a>
    </div>

    <!-- ORDERS LIST -->
    @if($orders->count() > 0)
    <div class="space-y-4">
        @foreach($orders as $order)
        <div class="bg-white rounded-3xl border border-gray-100 p-5 sm:p-6 shadow-sm hover:shadow-md transition">
            
            <!-- HEADER -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-gray-100 text-xs">
                <div class="flex items-center gap-3">
                    <span class="font-extrabold text-gray-900">{{ $order->order_number }}</span>
                    <span class="text-gray-400">•</span>
                    <span class="text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</span>
                </div>
                <div>
                    <span class="inline-block px-3 py-1 rounded-full font-extrabold text-[11px] border {{ $order->status_badge['class'] }}">
                        {{ $order->status_badge['label'] }}
                    </span>
                </div>
            </div>

            <!-- ITEMS SUMMARY BRIEF -->
            <div class="py-4 space-y-3">
                @foreach($order->items->take(2) as $item)
                <div class="flex items-center gap-3">
                    <img src="{{ $item->product ? $item->product->main_image : 'https://placehold.co/100x100?text=Produk' }}" class="w-12 h-12 object-cover rounded-xl border border-gray-100 flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-gray-900 truncate">{{ $item->product_name }}</p>
                        <p class="text-[11px] text-gray-500">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach

                @if($order->items->count() > 2)
                <p class="text-[11px] text-gray-400 font-semibold">+ {{ $order->items->count() - 2 }} produk lainnya</p>
                @endif
            </div>

            <!-- FOOTER TOTAL & ACTION -->
            <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                <div>
                    <span class="text-gray-500">Total Belanja:</span>
                    <span class="text-sm font-black text-brand-600 ml-1">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="px-4 py-2 rounded-xl border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition">
                        <i class="fa-solid fa-print mr-1"></i> Cetak Invoice
                    </a>
                    <a href="{{ route('orders.show', $order->id) }}" class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold shadow-sm transition">
                        Lihat Detail Pesanan <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>
                    </a>
                </div>
            </div>

        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
    @else
    <div class="bg-white rounded-3xl border border-gray-100 p-12 text-center my-6 max-w-lg mx-auto">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 text-2xl mx-auto mb-4">
            <i class="fa-solid fa-receipt"></i>
        </div>
        <h3 class="text-base font-bold text-gray-900 mb-1">Belum Ada Pesanan</h3>
        <p class="text-xs text-gray-500 mb-6">Anda belum memiliki transaksi pesanan dalam kategori ini.</p>
        <a href="{{ route('products.index') }}" class="bg-brand-600 text-white font-bold text-xs px-6 py-2.5 rounded-full inline-block">Belanja Sekarang</a>
    </div>
    @endif
</div>
@endsection
