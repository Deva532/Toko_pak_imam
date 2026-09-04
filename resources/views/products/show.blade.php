@extends('layouts.app')

@section('title', "{$product->name} | Toko Pak Imam")
@section('meta_description', Str::limit(strip_tags($product->description), 150))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ qty: 1, activeImage: '{{ $product->main_image }}' }">
    
    <!-- BREADCRUMB -->
    <nav class="flex text-xs text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 sm:space-x-2">
            <li><a href="{{ route('home') }}" class="hover:text-brand-600">Beranda</a></li>
            <li><i class="fa-solid fa-chevron-right text-[9px] mx-1 text-gray-400"></i></li>
            <li><a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-brand-600">{{ $product->category->name }}</a></li>
            <li><i class="fa-solid fa-chevron-right text-[9px] mx-1 text-gray-400"></i></li>
            <li class="font-bold text-gray-900 truncate max-w-[200px]">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- PRODUCT DETAIL CARD -->
    <div class="bg-white rounded-3xl border border-gray-100 p-6 sm:p-8 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 mb-12">
        
        <!-- IMAGE GALLERY -->
        <div>
            <div class="aspect-square rounded-3xl bg-gray-50 overflow-hidden border border-gray-100 mb-4 shadow-inner relative">
                <img :src="activeImage" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @if($product->discount_percentage > 0)
                <span class="absolute top-4 left-4 bg-red-600 text-white text-xs font-black px-3 py-1 rounded-full shadow-md">
                    PROMO -{{ $product->discount_percentage }}%
                </span>
                @endif
            </div>

            @if($product->images->count() > 0)
            <div class="flex items-center gap-3 overflow-x-auto no-scrollbar pb-2">
                <button @click="activeImage = '{{ $product->main_image }}'" class="w-16 h-16 rounded-2xl overflow-hidden border-2 transition flex-shrink-0" :class="activeImage === '{{ $product->main_image }}' ? 'border-brand-600 ring-2 ring-brand-100' : 'border-gray-200 opacity-70'">
                    <img src="{{ $product->main_image }}" class="w-full h-full object-cover">
                </button>
                @foreach($product->images as $img)
                <button @click="activeImage = '{{ $img->image_path }}'" class="w-16 h-16 rounded-2xl overflow-hidden border-2 transition flex-shrink-0" :class="activeImage === '{{ $img->image_path }}' ? 'border-brand-600 ring-2 ring-brand-100' : 'border-gray-200 opacity-70'">
                    <img src="{{ $img->image_path }}" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- PRODUCT INFO & ACTIONS -->
        <div class="flex flex-col justify-between">
            <div>
                <!-- CATEGORY & BRAND -->
                <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                    <span class="font-extrabold text-brand-600 uppercase tracking-wider bg-brand-50 px-3 py-1 rounded-full">{{ $product->category->name }}</span>
                    <span>SKU: {{ $product->sku }}</span>
                </div>

                <h1 class="text-xl sm:text-2xl font-black text-gray-900 leading-tight mb-3">
                    {{ $product->name }}
                </h1>

                <!-- RATING & SOLD -->
                <div class="flex items-center gap-4 text-xs text-gray-600 mb-6 pb-4 border-b border-gray-100">
                    <div class="flex items-center text-amber-400">
                        <i class="fa-solid fa-star"></i>
                        <span class="font-bold text-gray-900 ml-1">{{ $product->rating }}</span>
                    </div>
                    <span>•</span>
                    <span>Terjual <strong>{{ $product->sold_count }}</strong> Pcs</span>
                    <span>•</span>
                    <span>Stok Tersisa: <strong class="{{ $product->stock > 5 ? 'text-emerald-600' : 'text-amber-600' }}">{{ $product->stock }} Pcs</strong></span>
                </div>

                <!-- PRICE -->
                <div class="bg-gray-50 p-4 rounded-2xl mb-6">
                    <div class="text-xs text-gray-500 mb-1">Harga Spesial Toko Pak Imam</div>
                    <div class="flex items-baseline gap-3">
                        <span class="text-2xl sm:text-3xl font-black text-brand-600">
                            Rp{{ number_format($product->effective_price, 0, ',', '.') }}
                        </span>
                        @if($product->discount_price)
                        <span class="text-sm text-gray-400 line-through">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        @endif
                    </div>
                </div>

                <!-- QUANTITY PICKER -->
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-700 mb-2">Jumlah Pembelian</label>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center border border-gray-200 rounded-xl bg-gray-50">
                            <button @click="if(qty > 1) qty--" class="px-3 py-2 text-gray-600 hover:text-brand-600 font-bold transition">-</button>
                            <input type="number" x-model="qty" readonly class="w-12 text-center bg-transparent border-none text-xs font-bold focus:outline-none">
                            <button @click="if(qty < {{ $product->stock }}) qty++" class="px-3 py-2 text-gray-600 hover:text-brand-600 font-bold transition">+</button>
                        </div>
                        <span class="text-xs text-gray-500">Berat: {{ $product->weight }} gram</span>
                    </div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="space-y-3 pt-6 border-t border-gray-100">
                <div class="flex items-center gap-3">
                    <button 
                        @click="addToCart({{ $product->id }}, qty)"
                        class="flex-1 bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-xs sm:text-sm py-3.5 rounded-2xl shadow-lg hover:shadow-xl transition transform active:scale-95 flex items-center justify-center gap-2"
                    >
                        <i class="fa-solid fa-cart-plus"></i> + Tambah ke Keranjang
                    </button>

                    @auth
                    <form method="POST" action="{{ route('customer.wishlist.toggle') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="p-3.5 rounded-2xl border border-gray-200 hover:border-brand-500 text-gray-600 hover:text-red-500 transition shadow-sm">
                            <i class="fa-regular fa-heart text-xl"></i>
                        </button>
                    </form>
                    @endauth
                </div>

                <!-- DESCRIPTION -->
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h3 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider mb-2">Deskripsi Produk</h3>
                    <p class="text-xs text-gray-600 leading-relaxed whitespace-pre-line">
                        {{ $product->description ?? 'Tidak ada deskripsi tambahan.' }}
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- RELATED PRODUCTS SECTION -->
    @if($relatedProducts->count() > 0)
    <div class="pt-6">
        <h2 class="text-lg font-extrabold text-gray-900 mb-4">Produk yang Mungkin Kamu Suka</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            @foreach($relatedProducts as $rel)
            <div class="bg-white rounded-2xl p-3 border border-gray-100 hover:border-brand-500 shadow-sm hover:shadow-lg transition flex flex-col justify-between group">
                <div>
                    <a href="{{ route('products.show', $rel->slug) }}" class="block overflow-hidden rounded-xl mb-2 aspect-square bg-gray-50">
                        <img src="{{ $rel->main_image }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </a>

                    <a href="{{ route('products.show', $rel->slug) }}" class="text-xs font-semibold text-gray-900 hover:text-brand-600 line-clamp-2 leading-snug mb-2">
                        {{ $rel->name }}
                    </a>
                </div>

                <div>
                    <div class="text-xs font-black text-brand-600 mb-2">
                        Rp{{ number_format($rel->effective_price, 0, ',', '.') }}
                    </div>

                    <button 
                        onclick="addToCart({{ $rel->id }})" 
                        class="w-full bg-brand-50 hover:bg-brand-600 text-brand-700 hover:text-white text-xs font-bold py-1.5 rounded-xl transition active:scale-95"
                    >
                        + Keranjang
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
