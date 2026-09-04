@extends('layouts.app')

@section('title', isset($selectedCategory) ? "Jual {$selectedCategory->name} | Toko Pak Imam" : 'Katalog Produk | Toko Pak Imam')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- BREADCRUMB -->
    <nav class="flex text-xs text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 sm:space-x-2">
            <li><a href="{{ route('home') }}" class="hover:text-brand-600">Beranda</a></li>
            <li><i class="fa-solid fa-chevron-right text-[9px] mx-1 text-gray-400"></i></li>
            <li class="font-bold text-gray-900">
                {{ isset($selectedCategory) ? $selectedCategory->name : 'Semua Produk' }}
            </li>
        </ol>
    </nav>

    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- SIDEBAR FILTERS -->
        <aside class="w-full lg:w-64 flex-shrink-0" x-data="{ mobileOpen: false }">
            
            <!-- Mobile Toggle Button -->
            <button @click="mobileOpen = !mobileOpen" class="lg:hidden w-full bg-white border border-gray-200 p-3 rounded-2xl flex items-center justify-between text-xs font-bold text-gray-800 shadow-sm mb-4">
                <span><i class="fa-solid fa-filter text-brand-600 mr-2"></i> Filter & Urutkan Produk</span>
                <i class="fa-solid fa-chevron-down text-gray-400"></i>
            </button>

            <div :class="mobileOpen ? 'block' : 'hidden lg:block'" class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-6">
                <form action="{{ route('products.index') }}" method="GET" class="space-y-6">
                    @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif

                    <!-- Header & Reset -->
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <h3 class="text-sm font-extrabold text-gray-900">Filter Produk</h3>
                        <a href="{{ route('products.index') }}" class="text-[11px] font-bold text-brand-600 hover:underline">Reset Filter</a>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <h4 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider mb-3">Kategori</h4>
                        <div class="space-y-2 max-h-56 overflow-y-auto no-scrollbar pr-1 text-xs">
                            <label class="flex items-center text-gray-700 hover:text-brand-600 cursor-pointer">
                                <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} class="text-brand-600 focus:ring-brand-500 mr-2">
                                <span>Semua Kategori</span>
                            </label>
                            @foreach($categories as $cat)
                            <label class="flex items-center text-gray-700 hover:text-brand-600 cursor-pointer justify-between">
                                <span class="flex items-center">
                                    <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'checked' : '' }} class="text-brand-600 focus:ring-brand-500 mr-2">
                                    {{ $cat->name }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Brand Filter -->
                    <div>
                        <h4 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider mb-3">Brand / Merek</h4>
                        <div class="space-y-2 max-h-40 overflow-y-auto no-scrollbar pr-1 text-xs">
                            <label class="flex items-center text-gray-700 hover:text-brand-600 cursor-pointer">
                                <input type="radio" name="brand" value="" {{ !request('brand') ? 'checked' : '' }} class="text-brand-600 focus:ring-brand-500 mr-2">
                                <span>Semua Brand</span>
                            </label>
                            @foreach($brands as $b)
                            <label class="flex items-center text-gray-700 hover:text-brand-600 cursor-pointer">
                                <input type="radio" name="brand" value="{{ $b->slug }}" {{ request('brand') === $b->slug ? 'checked' : '' }} class="text-brand-600 focus:ring-brand-500 mr-2">
                                <span>{{ $b->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div>
                        <h4 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider mb-3">Rentang Harga (Rp)</h4>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="bg-gray-50 border border-gray-200 rounded-xl p-2 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="bg-gray-50 border border-gray-200 rounded-xl p-2 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        </div>
                    </div>

                    <!-- Status Toggles -->
                    <div class="space-y-2 pt-2 border-t border-gray-100 text-xs">
                        <label class="flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="promo" value="1" {{ request('promo') ? 'checked' : '' }} class="rounded text-brand-600 focus:ring-brand-500 mr-2">
                            <span class="font-bold text-red-600"><i class="fa-solid fa-fire text-amber-500 mr-1"></i> Promo Diskon</span>
                        </label>
                        <label class="flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} class="rounded text-brand-600 focus:ring-brand-500 mr-2">
                            <span>Tersedia Stok Saja</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs py-2.5 rounded-xl shadow-md transition">
                        Terapkan Filter
                    </button>
                </form>
            </div>
        </aside>

        <!-- PRODUCT CATALOG GRID -->
        <main class="flex-1 min-w-0">
            
            <!-- CATALOG HEADER & SORTING -->
            <div class="bg-white rounded-3xl border border-gray-100 p-4 sm:p-6 shadow-sm mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg font-extrabold text-gray-900">
                        {{ isset($selectedCategory) ? $selectedCategory->name : 'Katalog Produk Toko Pak Imam' }}
                    </h1>
                    <p class="text-xs text-gray-500">Menampilkan {{ $products->total() }} produk kebutuhan harian</p>
                </div>

                <!-- Sorting Select -->
                <form action="{{ route('products.index') }}" method="GET" class="flex items-center gap-2">
                    @foreach(request()->except('sort', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach

                    <label class="text-xs font-bold text-gray-500 whitespace-nowrap">Urutkan:</label>
                    <select name="sort" onchange="this.form.submit()" class="bg-gray-50 border border-gray-200 rounded-xl py-2 px-3 text-xs font-semibold text-gray-800 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="best_seller" {{ request('sort') === 'best_seller' ? 'selected' : '' }}>Terlaris</option>
                        <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                        <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Harga Termurah</option>
                        <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Harga Termahal</option>
                    </select>
                </form>
            </div>

            <!-- PRODUCT GRID -->
            @if($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($products as $product)
                <div class="bg-white rounded-2xl p-4 border border-gray-100 hover:border-brand-500 shadow-sm hover:shadow-xl transition flex flex-col justify-between group relative">
                    
                    @if($product->is_promo && $product->discount_percentage > 0)
                    <div class="absolute top-3 left-3 bg-red-600 text-white text-[10px] font-black px-2 py-0.5 rounded-full shadow-sm z-10">
                        -{{ $product->discount_percentage }}%
                    </div>
                    @endif

                    <div>
                        <a href="{{ route('products.show', $product->slug) }}" class="block overflow-hidden rounded-xl mb-3 aspect-square bg-gray-50">
                            <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </a>

                        <div class="flex items-center justify-between text-[10px] text-gray-500 mb-1">
                            <span class="font-bold text-brand-600 uppercase">{{ $product->category->name }}</span>
                            <span><i class="fa-solid fa-star text-amber-400"></i> {{ $product->rating }}</span>
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
                            class="w-full bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold py-2 rounded-xl flex items-center justify-center gap-1.5 transition active:scale-95 shadow-sm"
                        >
                            <i class="fa-solid fa-plus text-[10px]"></i> Keranjang
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- PAGINATION -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>

            @else
            <div class="bg-white rounded-3xl border border-gray-100 p-12 text-center my-6">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 text-2xl mx-auto mb-4">
                    <i class="fa-solid fa-magnifying-glass-minus"></i>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">Produk Tidak Ditemukan</h3>
                <p class="text-xs text-gray-500 mb-6">Coba ubah kata kunci pencarian atau reset filter di sebelah kiri.</p>
                <a href="{{ route('products.index') }}" class="bg-brand-600 text-white font-bold text-xs px-6 py-2.5 rounded-full inline-block">Reset Filter</a>
            </div>
            @endif
        </main>
    </div>
</div>
@endsection
