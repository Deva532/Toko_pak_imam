@extends('layouts.app')

@section('title', 'Dashboard Akun | Toko Pak Imam')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        
        <!-- SIDEBAR MENU -->
        <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm h-fit space-y-2 text-xs font-bold">
            <div class="flex items-center gap-3 pb-4 mb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-full bg-brand-600 text-white flex items-center justify-center font-bold text-base">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-extrabold text-gray-900 truncate">{{ $user->name }}</p>
                    <p class="text-[11px] text-gray-400 font-normal truncate">{{ $user->email }}</p>
                </div>
            </div>

            <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl bg-brand-600 text-white shadow-sm">
                <i class="fa-solid fa-gauge-high text-sm w-4"></i> Dashboard Akun
            </a>
            <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-gray-700 hover:bg-gray-100 transition">
                <i class="fa-solid fa-box-open text-sm w-4"></i> Pesanan Saya
            </a>
            <a href="{{ route('customer.addresses') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-gray-700 hover:bg-gray-100 transition">
                <i class="fa-solid fa-location-dot text-sm w-4"></i> Buku Alamat
            </a>
            <a href="{{ route('customer.wishlist') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-gray-700 hover:bg-gray-100 transition">
                <i class="fa-solid fa-heart text-sm w-4"></i> Wishlist Saya
            </a>
            <a href="{{ route('customer.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-gray-700 hover:bg-gray-100 transition">
                <i class="fa-solid fa-user-gear text-sm w-4"></i> Pengaturan Profil
            </a>
        </div>

        <!-- MAIN DASHBOARD CONTENT -->
        <div class="md:col-span-3 space-y-6">
            
            <!-- STAT CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-boxes-packing"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Total Pesanan</p>
                        <h4 class="text-xl font-black text-gray-900">{{ $totalOrders }}</h4>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Pesanan Aktif</p>
                        <h4 class="text-xl font-black text-gray-900">{{ $pendingOrders }}</h4>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-heart"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Wishlist Produk</p>
                        <h4 class="text-xl font-black text-gray-900">{{ $wishlistCount }}</h4>
                    </div>
                </div>
            </div>

            <!-- RECENT ORDERS TABLE -->
            <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                    <h3 class="text-sm font-extrabold text-gray-900">Pesanan Terakhir</h3>
                    <a href="{{ route('orders.index') }}" class="text-xs font-bold text-brand-600 hover:underline">Lihat Semua</a>
                </div>

                @if($recentOrders->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($recentOrders as $order)
                    <div class="py-3 flex items-center justify-between text-xs">
                        <div>
                            <p class="font-extrabold text-gray-900">{{ $order->order_number }}</p>
                            <p class="text-[11px] text-gray-500">{{ $order->created_at->format('d M Y H:i') }} • {{ $order->items->count() }} item</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="font-black text-brand-600">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold border {{ $order->status_badge['class'] }}">
                                {{ $order->status_badge['label'] }}
                            </span>
                            <a href="{{ route('orders.show', $order->id) }}" class="text-brand-600 hover:underline font-bold">Detail</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-xs text-gray-500 py-4 text-center">Belum ada transaksi pesanan.</p>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
