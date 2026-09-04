@extends('layouts.app')

@section('title', 'Keranjang Belanja | Toko Pak Imam')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-xl sm:text-2xl font-black text-gray-900 mb-6 flex items-center gap-2">
        <i class="fa-solid fa-cart-shopping text-brand-600"></i> Keranjang Belanja Saya
    </h1>

    @if($cart->items->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- CART ITEMS LIST -->
        <div class="lg:col-span-2 space-y-4">
            @foreach($cart->items as $item)
            <div class="bg-white rounded-3xl border border-gray-100 p-4 sm:p-5 shadow-sm flex items-center gap-4 justify-between" id="cart-item-{{ $item->id }}">
                <div class="flex items-center gap-4 flex-1 min-w-0">
                    <img src="{{ $item->product->main_image }}" alt="{{ $item->product->name }}" class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-2xl border border-gray-100 flex-shrink-0">
                    
                    <div class="flex-1 min-w-0">
                        <span class="text-[10px] font-bold text-brand-600 uppercase tracking-wider block">{{ $item->product->category->name }}</span>
                        <a href="{{ route('products.show', $item->product->slug) }}" class="text-xs sm:text-sm font-bold text-gray-900 hover:text-brand-600 truncate block">
                            {{ $item->product->name }}
                        </a>

                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs font-black text-brand-600">
                                Rp{{ number_format($item->product->effective_price, 0, ',', '.') }}
                            </span>
                            @if($item->product->discount_price)
                            <span class="text-[10px] text-gray-400 line-through">
                                Rp{{ number_format($item->product->price, 0, ',', '.') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- QUANTITY & ACTIONS -->
                <div class="flex flex-col items-end gap-2">
                    <form method="POST" action="{{ route('cart.update', $item->id) }}" class="flex items-center border border-gray-200 rounded-xl bg-gray-50">
                        @csrf
                        @method('PUT')
                        <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}" class="px-2.5 py-1 text-gray-600 hover:text-brand-600 font-bold text-xs">-</button>
                        <span class="px-2 text-xs font-bold text-gray-900">{{ $item->quantity }}</span>
                        <button type="submit" name="quantity" value="{{ min($item->product->stock, $item->quantity + 1) }}" class="px-2.5 py-1 text-gray-600 hover:text-brand-600 font-bold text-xs">+</button>
                    </form>

                    <div class="flex items-center gap-3">
                        <span class="text-xs font-extrabold text-gray-900">
                            Subtotal: Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                        </span>

                        <form method="POST" action="{{ route('cart.destroy', $item->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs p-1" title="Hapus produk">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- SUMMARY SIDEBAR -->
        <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm h-fit space-y-6">
            <h3 class="text-sm font-extrabold text-gray-900 border-b border-gray-100 pb-4">Ringkasan Belanja</h3>

            <div class="space-y-3 text-xs">
                <div class="flex items-center justify-between text-gray-600">
                    <span>Total Produk ({{ $cart->item_count }} item)</span>
                    <span class="font-bold text-gray-900">Rp{{ number_format($cart->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between text-gray-600">
                    <span>Estimasi Ongkir</span>
                    <span class="font-bold text-emerald-600">Dihitung saat Checkout</span>
                </div>
                <div class="border-t border-gray-100 pt-3 flex items-center justify-between text-sm font-extrabold text-gray-900">
                    <span>Total Pembayaran</span>
                    <span class="text-lg text-brand-600">Rp{{ number_format($cart->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>

            <a href="{{ route('checkout.index') }}" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-xs sm:text-sm py-3.5 rounded-2xl shadow-lg transition flex items-center justify-center gap-2">
                Lanjut ke Checkout <i class="fa-solid fa-arrow-right"></i>
            </a>

            <div class="bg-brand-50 rounded-2xl p-3 text-[11px] text-brand-800 flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-brand-600 text-base"></i>
                <span>Gunakan kode voucher <strong>PAKIMAMHEMAT</strong> di checkout untuk potongan Rp10.000!</span>
            </div>
        </div>

    </div>
    @else
    <div class="bg-white rounded-3xl border border-gray-100 p-12 text-center my-6 max-w-lg mx-auto">
        <div class="w-20 h-20 bg-brand-50 rounded-full flex items-center justify-center text-brand-600 text-3xl mx-auto mb-4">
            <i class="fa-solid fa-basket-shopping"></i>
        </div>
        <h3 class="text-base font-bold text-gray-900 mb-1">Keranjang Belanja Masih Kosong</h3>
        <p class="text-xs text-gray-500 mb-6">Yuk, isi keranjangmu dengan bahan makanan dan sembako berkualitas dari Toko Pak Imam!</p>
        <a href="{{ route('products.index') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs px-6 py-3 rounded-full inline-block shadow-md">
            Mulai Belanja Sekarang
        </a>
    </div>
    @endif
</div>
@endsection
