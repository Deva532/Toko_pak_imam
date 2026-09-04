@extends('layouts.app')

@section('title', 'Wishlist Saya | Toko Pak Imam')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        
        <!-- SIDEBAR MENU -->
        <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm h-fit space-y-2 text-xs font-bold">
            <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-gray-700 hover:bg-gray-100 transition">
                <i class="fa-solid fa-gauge-high text-sm w-4"></i> Dashboard Akun
            </a>
            <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-gray-700 hover:bg-gray-100 transition">
                <i class="fa-solid fa-box-open text-sm w-4"></i> Pesanan Saya
            </a>
            <a href="{{ route('customer.addresses') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-gray-700 hover:bg-gray-100 transition">
                <i class="fa-solid fa-location-dot text-sm w-4"></i> Buku Alamat
            </a>
            <a href="{{ route('customer.wishlist') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl bg-brand-600 text-white shadow-sm">
                <i class="fa-solid fa-heart text-sm w-4"></i> Wishlist Saya
            </a>
            <a href="{{ route('customer.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-gray-700 hover:bg-gray-100 transition">
                <i class="fa-solid fa-user-gear text-sm w-4"></i> Pengaturan Profil
            </a>
        </div>

        <!-- MAIN WISHLIST GRID -->
        <div class="md:col-span-3">
            <div class="bg-white rounded-3xl border border-gray-100 p-6 sm:p-8 shadow-sm">
                <h3 class="text-base font-extrabold text-gray-900 mb-6 pb-3 border-b border-gray-100">Daftar Produk Favorit (Wishlist)</h3>

                @if($wishlists->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach($wishlists as $item)
                    @if($item->product)
                    <div class="bg-white rounded-2xl p-3 border border-gray-100 shadow-sm flex flex-col justify-between group">
                        <div>
                            <a href="{{ route('products.show', $item->product->slug) }}" class="block overflow-hidden rounded-xl mb-2 aspect-square bg-gray-50">
                                <img src="{{ $item->product->main_image }}" class="w-full h-full object-cover">
                            </a>
                            <a href="{{ route('products.show', $item->product->slug) }}" class="text-xs font-bold text-gray-900 hover:text-brand-600 line-clamp-2 leading-snug mb-1">
                                {{ $item->product->name }}
                            </a>
                            <span class="text-xs font-black text-brand-600">
                                Rp{{ number_format($item->product->effective_price, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="mt-3 space-y-1.5">
                            <button onclick="addToCart({{ $item->product->id }})" class="w-full bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold py-1.5 rounded-xl transition">
                                + Keranjang
                            </button>

                            <form method="POST" action="{{ route('customer.wishlist.toggle') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                <button type="submit" class="w-full text-rose-600 hover:text-rose-700 text-[11px] font-bold py-1 text-center">
                                    Hapus Wishlist
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <i class="fa-regular fa-heart text-4xl text-gray-300 mb-2"></i>
                    <p class="text-xs text-gray-500">Belum ada produk favorit disimpan di wishlist Anda.</p>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
