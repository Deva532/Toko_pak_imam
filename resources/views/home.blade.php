@extends('layouts.app')

@section('title', 'Toko Pak Imam | Minimarket Online Belanja Kebutuhan Harian Modern')

@section('content')

<!-- HERO BANNER SECTION -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
    <div class="relative bg-gradient-to-r from-brand-800 via-brand-700 to-emerald-600 rounded-3xl overflow-hidden shadow-xl p-6 sm:p-10 text-white min-h-[220px] sm:min-h-[280px] flex items-center justify-between">
        <div class="max-w-xl z-10 space-y-4">
            <span class="inline-block bg-accent-500 text-slate-950 text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                <i class="fa-solid fa-bolt mr-1"></i> Minimarket Online Terpercaya
            </span>
            <h1 class="text-2xl sm:text-4xl font-black leading-tight tracking-tight">
                Belanja Kebutuhan Harian Jadi Lebih Mudah & Cepat
            </h1>
            <p class="text-xs sm:text-sm text-brand-100 font-medium leading-relaxed">
                Temukan Sembako, Indomie, Minyak Goreng, Susu UHT, dan Sabun favoritmu di Toko Pak Imam. Antar langsung dalam 2 jam!
            </p>
            <div class="pt-2 flex flex-wrap items-center gap-3">
                <a href="{{ route('products.index') }}" class="bg-accent-500 hover:bg-accent-600 text-slate-950 font-extrabold text-xs sm:text-sm px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition transform active:scale-95 inline-flex items-center gap-2">
                    Belanja Sekarang <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="{{ route('products.index', ['promo' => 1]) }}" class="bg-white/10 hover:bg-white/20 text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-full border border-white/30 backdrop-blur-sm transition">
                    Lihat Promo Hari Ini
                </a>
            </div>
        </div>

        <div class="hidden md:flex items-center justify-center relative w-64 h-64">
            <div class="w-48 h-48 rounded-full bg-white/10 absolute animate-pulse"></div>
            <i class="fa-solid fa-basket-shopping text-9xl text-white/90 drop-shadow-2xl relative z-10"></i>
        </div>
    </div>
</div>

<!-- CATEGORY SECTION -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg sm:text-xl font-extrabold text-gray-900 tracking-tight">Belanja Berdasarkan Kategori</h2>
            <p class="text-xs text-gray-500">Pilih kategori produk kebutuhan harianmu</p>
        </div>
        <a href="{{ route('products.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1">
            Lihat Semua <i class="fa-solid fa-chevron-right text-[10px]"></i>
        </a>
    </div>

    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-10 gap-3 sm:gap-4">
        @foreach($categories as $category)
        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="bg-white p-3 sm:p-4 rounded-2xl border border-gray-100 hover:border-brand-500 hover:shadow-lg transition text-center group flex flex-col items-center">
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-brand-50 group-hover:bg-brand-600 text-brand-600 group-hover:text-white flex items-center justify-center text-xl sm:text-2xl transition-colors mb-2 shadow-sm">
                @if($category->icon === 'shopping-bag') <i class="fa-solid fa-bag-shopping"></i>
                @elseif($category->icon === 'coffee') <i class="fa-solid fa-mug-hot"></i>
                @elseif($category->icon === 'utensils') <i class="fa-solid fa-bowl-food"></i>
                @elseif($category->icon === 'cookie') <i class="fa-solid fa-cookie-bite"></i>
                @elseif($category->icon === 'sparkles') <i class="fa-solid fa-pump-soap"></i>
                @elseif($category->icon === 'home') <i class="fa-solid fa-spray-can-sparkles"></i>
                @elseif($category->icon === 'baby') <i class="fa-solid fa-baby-carriage"></i>
                @elseif($category->icon === 'milk') <i class="fa-solid fa-bottle-water"></i>
                @elseif($category->icon === 'zap') <i class="fa-solid fa-plug"></i>
                @elseif($category->icon === 'pen-tool') <i class="fa-solid fa-pen-ruler"></i>
                @else <i class="fa-solid fa-boxes-stacked"></i>
                @endif
            </div>
            <span class="text-[11px] font-bold text-gray-700 group-hover:text-brand-600 line-clamp-2 leading-tight">
                {{ $category->name }}
            </span>
        </a>
        @endforeach
    </div>
</div>

<!-- PROMO HARI INI SECTION -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
    <div class="bg-gradient-to-r from-red-500 to-amber-500 rounded-3xl p-6 sm:p-8 shadow-xl text-white mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center text-xl font-bold text-yellow-300">
                    <i class="fa-solid fa-fire"></i>
                </div>
                <div>
                    <h2 class="text-xl font-extrabold tracking-tight">Promo Hari Ini</h2>
                    <p class="text-xs text-amber-100">Diskon spesial harga tercoret terbatas untukmu</p>
                </div>
            </div>
            <a href="{{ route('products.index', ['promo' => 1]) }}" class="bg-white text-red-600 hover:bg-amber-50 font-bold text-xs px-4 py-2 rounded-full shadow-sm transition self-start sm:self-auto">
                Lihat Semua Promo <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4">
            @foreach($promoProducts as $product)
            <div class="bg-white rounded-2xl p-3 sm:p-4 text-gray-900 shadow-md flex flex-col justify-between hover:shadow-xl transition relative group border border-amber-100">
                
                <!-- PROMO BADGE -->
                <div class="absolute top-3 left-3 bg-red-600 text-white text-[10px] font-black px-2 py-0.5 rounded-full shadow-sm z-10">
                    -{{ $product->discount_percentage }}%
                </div>

                <div>
                    <a href="{{ route('products.show', $product->slug) }}" class="block overflow-hidden rounded-xl mb-3 aspect-square bg-gray-50">
                        <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </a>

                    <span class="text-[10px] font-semibold text-brand-600 uppercase tracking-wider block mb-0.5 truncate">{{ $product->category->name }}</span>
                    <a href="{{ route('products.show', $product->slug) }}" class="text-xs font-bold text-gray-900 hover:text-brand-600 line-clamp-2 leading-snug mb-2">
                        {{ $product->name }}
                    </a>
                </div>

                <div>
                    <div class="mb-3">
                        <div class="text-sm font-black text-brand-600">
                            Rp{{ number_format($product->effective_price, 0, ',', '.') }}
                        </div>
                        @if($product->discount_price)
                        <div class="text-[10px] text-gray-400 line-through">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </div>
                        @endif
                    </div>

                    <button 
                        onclick="addToCart({{ $product->id }})" 
                        class="w-full bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold py-2 rounded-xl flex items-center justify-center gap-1.5 transition shadow-sm active:scale-95"
                    >
                        <i class="fa-solid fa-plus text-[10px]"></i> Keranjang
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- PRODUK TERLARIS SECTION -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg sm:text-xl font-extrabold text-gray-900 tracking-tight">Produk Terlaris</h2>
            <p class="text-xs text-gray-500">Paling banyak dibeli oleh pelanggan Toko Pak Imam</p>
        </div>
        <a href="{{ route('products.index', ['sort' => 'best_seller']) }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1">
            Lihat Semua <i class="fa-solid fa-chevron-right text-[10px]"></i>
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4">
        @foreach($bestSellers as $product)
        <div class="bg-white rounded-2xl p-4 border border-gray-100 hover:border-brand-500 shadow-sm hover:shadow-xl transition flex flex-col justify-between group">
            <div>
                <a href="{{ route('products.show', $product->slug) }}" class="block overflow-hidden rounded-xl mb-3 aspect-square bg-gray-50">
                    <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </a>

                <div class="flex items-center justify-between text-[10px] text-gray-500 mb-1">
                    <span class="font-semibold text-brand-600 uppercase">{{ $product->category->name }}</span>
                    <span><i class="fa-solid fa-star text-amber-400"></i> {{ $product->rating }} ({{ $product->sold_count }}+ Terjual)</span>
                </div>

                <a href="{{ route('products.show', $product->slug) }}" class="text-xs font-bold text-gray-900 hover:text-brand-600 line-clamp-2 leading-snug mb-2">
                    {{ $product->name }}
                </a>
            </div>

            <div>
                <div class="mb-3">
                    <span class="text-sm font-black text-brand-600">
                        Rp{{ number_format($product->effective_price, 0, ',', '.') }}
                    </span>
                    @if($product->discount_price)
                    <span class="text-[10px] text-gray-400 line-through ml-1">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    @endif
                </div>

                <button 
                    onclick="addToCart({{ $product->id }})" 
                    class="w-full bg-gray-100 hover:bg-brand-600 text-gray-800 hover:text-white text-xs font-bold py-2 rounded-xl flex items-center justify-center gap-1.5 transition active:scale-95"
                >
                    <i class="fa-solid fa-cart-plus"></i> + Keranjang
                </button>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- VOUCHER BANNER -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
    <div class="bg-gradient-to-r from-brand-900 to-brand-700 rounded-3xl p-6 sm:p-8 text-white flex flex-col sm:flex-row items-center justify-between gap-6 shadow-lg">
        <div class="space-y-2 text-center sm:text-left">
            <span class="bg-accent-500 text-slate-950 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">Voucher Hemat</span>
            <h3 class="text-xl sm:text-2xl font-black">Diskon Potongan Rp10.000</h3>
            <p class="text-xs text-brand-100">Gunakan kode voucher di bawah ini saat checkout dengan minimal belanja Rp50.000</p>
        </div>
        <div class="bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-2xl text-center font-mono font-black text-xl text-yellow-300 tracking-wider flex items-center gap-3">
            <span>PAKIMAMHEMAT</span>
            <button onclick="navigator.clipboard.writeText('PAKIMAMHEMAT'); alert('Kode voucher PAKIMAMHEMAT disalin!')" class="text-xs bg-accent-500 hover:bg-accent-600 text-slate-950 font-sans font-extrabold px-3 py-1.5 rounded-xl transition">
                Salin
            </button>
        </div>
    </div>
</div>

<!-- REKOMENDASI UNTUKMU SECTION -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg sm:text-xl font-extrabold text-gray-900 tracking-tight">Rekomendasi Untukmu</h2>
            <p class="text-xs text-gray-500">Pilihan produk terbaik untuk stok dapur dan rumah tangga</p>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($recommendedProducts as $product)
        <div class="bg-white rounded-2xl p-3 border border-gray-100 hover:border-brand-500 shadow-sm hover:shadow-lg transition flex flex-col justify-between group">
            <div>
                <a href="{{ route('products.show', $product->slug) }}" class="block overflow-hidden rounded-xl mb-2 aspect-square bg-gray-50">
                    <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </a>

                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider block mb-0.5 truncate">{{ $product->category->name }}</span>
                <a href="{{ route('products.show', $product->slug) }}" class="text-xs font-semibold text-gray-900 hover:text-brand-600 line-clamp-2 leading-snug mb-2">
                    {{ $product->name }}
                </a>
            </div>

            <div>
                <div class="mb-2">
                    <span class="text-xs font-black text-brand-600">
                        Rp{{ number_format($product->effective_price, 0, ',', '.') }}
                    </span>
                    @if($product->discount_price)
                    <span class="text-[9px] text-gray-400 line-through ml-1">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    @endif
                </div>

                <button 
                    onclick="addToCart({{ $product->id }})" 
                    class="w-full bg-brand-50 hover:bg-brand-600 text-brand-700 hover:text-white text-xs font-bold py-1.5 rounded-xl transition active:scale-95"
                >
                    + Keranjang
                </button>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- WHY US / KEUNGGULAN TOKO -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16">
    <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm text-center">
        <h2 class="text-xl font-extrabold text-gray-900 mb-2">Kenapa Belanja di Toko Pak Imam?</h2>
        <p class="text-xs text-gray-500 mb-8 max-w-xl mx-auto">Pengalaman belanja minimarket modern dengan standar kualitas terpercaya</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <div class="p-4 rounded-2xl bg-gray-50">
                <div class="w-12 h-12 bg-brand-100 text-brand-600 rounded-full flex items-center justify-center text-xl mx-auto mb-3">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h4 class="text-sm font-bold text-gray-900 mb-1">Produk Berkualitas</h4>
                <p class="text-xs text-gray-500">100% barang asli, dikemas higienis, dan terjamin kebersihannya.</p>
            </div>

            <div class="p-4 rounded-2xl bg-gray-50">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-xl mx-auto mb-3">
                    <i class="fa-solid fa-tag"></i>
                </div>
                <h4 class="text-sm font-bold text-gray-900 mb-1">Harga Bersaing</h4>
                <p class="text-xs text-gray-500">Harga jujur minimarket hemat dengan diskon reguler setiap hari.</p>
            </div>

            <div class="p-4 rounded-2xl bg-gray-50">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xl mx-auto mb-3">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <h4 class="text-sm font-bold text-gray-900 mb-1">Proses & Antar Cepat</h4>
                <p class="text-xs text-gray-500">Pesanan langsung diproses kurir toko dan tiba dalam hitungan jam.</p>
            </div>

            <div class="p-4 rounded-2xl bg-gray-50">
                <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-xl mx-auto mb-3">
                    <i class="fa-solid fa-shield-cat"></i>
                </div>
                <h4 class="text-sm font-bold text-gray-900 mb-1">Pengiriman Aman</h4>
                <p class="text-xs text-gray-500">Pengemasan tebal anti-rusak untuk barang pecah belah & cairan.</p>
            </div>
        </div>
    </div>
</div>

@endsection
