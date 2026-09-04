<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Toko Pak Imam | Belanja Kebutuhan Harian Online Minimarket')</title>
    <meta name="description" content="@yield('meta_description', 'Toko Pak Imam - Minimarket online terpercaya untuk belanja kebutuhan harian, sembako, makanan, minuman, dan perlengkapan rumah tangga cepat dan hemat.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Vite / CDN Fallback for styling assurance) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        accent: {
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen pb-16 md:pb-0" x-data="globalApp()">

    <!-- TOP ANNOUNCEMENT BAR -->
    <div class="bg-brand-800 text-white text-xs py-1.5 px-4 text-center font-medium flex items-center justify-between">
        <div class="max-w-7xl mx-auto flex items-center justify-between w-full">
            <span class="truncate"><i class="fa-solid fa-truck-fast mr-1.5 text-accent-500"></i> Gratis Ongkir Khusus Pengiriman Pertama dengan Kode Voucher: <strong>PAKIMAMHEMAT</strong></span>
            <div class="hidden sm:flex items-center space-x-4 text-xs text-brand-100">
                <a href="#" class="hover:text-white transition"><i class="fa-solid fa-store mr-1"></i> Lokasi Toko</a>
                <a href="#" class="hover:text-white transition"><i class="fa-solid fa-circle-question mr-1"></i> Bantuan</a>
            </div>
        </div>
    </div>

    <!-- MAIN HEADER -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-3 sm:gap-6">

                <!-- BRAND LOGO -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group flex-shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center text-white font-black text-xl shadow-md group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-basket-shopping text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-black text-xl tracking-tight text-gray-900 leading-none">Toko Pak Imam</span>
                        <span class="text-[10px] font-semibold tracking-wider text-brand-600 uppercase">Minimarket Online</span>
                    </div>
                </a>

                <!-- SEARCH BAR WITH AUTOCOMPLETE -->
                <div class="flex-1 max-w-2xl relative" x-data="searchAutocomplete()">
                    <form action="{{ route('products.index') }}" method="GET" class="relative">
                        <div class="relative flex items-center">
                            <input 
                                type="text" 
                                name="q" 
                                x-model="query"
                                @input.debounce.300ms="fetchSuggestions()"
                                @focus="open = true"
                                @click.away="open = false"
                                placeholder="Cari beras, minyak, indomie, susu, sabun..." 
                                class="w-full bg-gray-100 border border-gray-200 rounded-full py-2.5 pl-11 pr-24 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all shadow-inner"
                                autocomplete="off"
                            >
                            <i class="fa-solid fa-magnifying-glass absolute left-4 text-gray-400 text-sm"></i>
                            <button type="submit" class="absolute right-1.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold px-4 py-1.5 rounded-full transition-colors">
                                Cari
                            </button>
                        </div>
                    </form>

                    <!-- AUTOCOMPLETE DROPDOWN -->
                    <div 
                        x-show="open && (suggestions.products.length > 0 || suggestions.categories.length > 0 || loading)" 
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden"
                    >
                        <template x-if="loading">
                            <div class="p-4 text-center text-xs text-gray-500 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-circle-notch fa-spin text-brand-600"></i> Mencari produk...
                            </div>
                        </template>

                        <template x-if="!loading && suggestions.categories && suggestions.categories.length > 0">
                            <div class="p-2 border-b border-gray-100 bg-gray-50">
                                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider px-2">Kategori</span>
                                <div class="flex flex-wrap gap-1.5 mt-1 px-2">
                                    <template x-for="cat in suggestions.categories" :key="cat.id">
                                        <a :href="'/products?category=' + cat.slug" class="text-xs bg-white border border-gray-200 hover:border-brand-500 px-3 py-1 rounded-full text-gray-700 hover:text-brand-600 transition">
                                            <span x-text="cat.name"></span>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <template x-if="!loading && suggestions.products && suggestions.products.length > 0">
                            <div class="p-2 divide-y divide-gray-100">
                                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider px-2 block mb-1">Produk</span>
                                <template x-for="prod in suggestions.products" :key="prod.id">
                                    <a :href="'/products/' + prod.slug" class="flex items-center gap-3 p-2 hover:bg-brand-50/50 rounded-xl transition">
                                        <img :src="prod.main_image || 'https://placehold.co/100x100?text=Produk'" class="w-10 h-10 object-cover rounded-lg border border-gray-100 flex-shrink-0">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold text-gray-900 truncate" x-text="prod.name"></p>
                                            <div class="flex items-center gap-2 text-xs">
                                                <span class="font-bold text-brand-600" x-text="formatRupiah(prod.discount_price || prod.price)"></span>
                                                <template x-if="prod.discount_price">
                                                    <span class="text-[10px] text-gray-400 line-through" x-text="formatRupiah(prod.price)"></span>
                                                </template>
                                            </div>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- RIGHT HEADER ACTIONS -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    
                    <!-- WISHLIST -->
                    @auth
                    <a href="{{ route('customer.wishlist') }}" class="relative text-gray-600 hover:text-brand-600 p-2 rounded-full hover:bg-gray-100 transition hidden sm:inline-flex" title="Wishlist">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </a>
                    @endauth

                    <!-- CART BADGE BUTTON -->
                    <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-brand-600 p-2 rounded-full hover:bg-brand-50 transition flex items-center">
                        <i class="fa-solid fa-cart-shopping text-xl text-gray-700"></i>
                        <span 
                            x-text="cartCount" 
                            x-show="cartCount > 0"
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-extrabold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm"
                        ></span>
                    </a>

                    <!-- USER ACCOUNT DROPDOWN OR LOGIN BUTTON -->
                    @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-2 text-xs font-semibold text-gray-700 hover:text-brand-600 p-1.5 rounded-full hover:bg-gray-100 transition focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-brand-600 text-white flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:inline-block max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 hidden md:inline-block"></i>
                        </button>

                        <!-- USER DROPDOWN MENU -->
                        <div x-show="open" x-cloak class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-xs font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-semibold uppercase rounded-full {{ Auth::user()->isAdmin() ? 'bg-purple-100 text-purple-700' : 'bg-brand-100 text-brand-700' }}">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>

                            @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-xs text-purple-700 hover:bg-purple-50 font-semibold">
                                <i class="fa-solid fa-gauge-high mr-2 text-purple-600"></i> Admin Dashboard
                            </a>
                            @endif

                            <a href="{{ route('customer.dashboard') }}" class="flex items-center px-4 py-2 text-xs text-gray-700 hover:bg-gray-50">
                                <i class="fa-solid fa-user mr-2 text-gray-400"></i> Dashboard Akun
                            </a>
                            <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2 text-xs text-gray-700 hover:bg-gray-50">
                                <i class="fa-solid fa-box-open mr-2 text-gray-400"></i> Pesanan Saya
                            </a>
                            <a href="{{ route('customer.addresses') }}" class="flex items-center px-4 py-2 text-xs text-gray-700 hover:bg-gray-50">
                                <i class="fa-solid fa-location-dot mr-2 text-gray-400"></i> Alamat Pengiriman
                            </a>
                            <a href="{{ route('customer.wishlist') }}" class="flex items-center px-4 py-2 text-xs text-gray-700 hover:bg-gray-50">
                                <i class="fa-solid fa-heart mr-2 text-gray-400"></i> Wishlist
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-xs text-red-600 hover:bg-red-50 font-semibold">
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar / Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('login') }}" class="text-xs font-bold text-gray-700 hover:text-brand-600 px-3 py-2 rounded-full hover:bg-gray-100 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="text-xs font-bold bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-full shadow-sm transition">
                            Daftar
                        </a>
                    </div>
                    @endauth

                </div>
            </div>
        </div>

        <!-- CATEGORY BAR NAV -->
        <nav class="bg-gray-50 border-t border-gray-100 hidden md:block">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center space-x-6 py-2 overflow-x-auto no-scrollbar text-xs font-semibold">
                <a href="{{ route('products.index') }}" class="text-brand-700 hover:text-brand-800 flex items-center gap-1.5 flex-shrink-0">
                    <i class="fa-solid fa-grid-2"></i> Semua Produk
                </a>
                <span class="text-gray-300">|</span>
                <a href="{{ route('products.index', ['promo' => 1]) }}" class="text-red-600 hover:text-red-700 flex items-center gap-1 flex-shrink-0 font-bold">
                    <i class="fa-solid fa-fire text-amber-500"></i> Promo Hari Ini
                </a>
                <span class="text-gray-300">|</span>
                <a href="{{ route('products.index', ['category' => 'sembako']) }}" class="text-gray-600 hover:text-brand-600 flex-shrink-0">Sembako</a>
                <a href="{{ route('products.index', ['category' => 'makanan-instant']) }}" class="text-gray-600 hover:text-brand-600 flex-shrink-0">Makanan Instant</a>
                <a href="{{ route('products.index', ['category' => 'minuman']) }}" class="text-gray-600 hover:text-brand-600 flex-shrink-0">Minuman</a>
                <a href="{{ route('products.index', ['category' => 'susu-olahan']) }}" class="text-gray-600 hover:text-brand-600 flex-shrink-0">Susu & Olahan</a>
                <a href="{{ route('products.index', ['category' => 'snack-biskuit']) }}" class="text-gray-600 hover:text-brand-600 flex-shrink-0">Snack & Biskuit</a>
                <a href="{{ route('products.index', ['category' => 'perawatan-rumah']) }}" class="text-gray-600 hover:text-brand-600 flex-shrink-0">Perawatan Rumah</a>
                <a href="{{ route('products.index', ['category' => 'perawatan-tubuh']) }}" class="text-gray-600 hover:text-brand-600 flex-shrink-0">Perawatan Tubuh</a>
                <a href="{{ route('products.index', ['category' => 'kebutuhan-bayi']) }}" class="text-gray-600 hover:text-brand-600 flex-shrink-0">Kebutuhan Bayi</a>
            </div>
        </nav>
    </header>

    <!-- FLASH MESSAGES -->
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 mt-4" x-data="{ show: true }" x-show="show" x-transition>
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3 text-sm font-medium">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="max-w-7xl mx-auto px-4 mt-4" x-data="{ show: true }" x-show="show" x-transition>
        <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl p-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3 text-sm font-medium">
                <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    @endif

    <!-- MAIN CONTENT -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-300 mt-16 border-t border-gray-800">
        <!-- TRUST BADGES -->
        <div class="bg-brand-900 border-b border-brand-800 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-brand-800 flex items-center justify-center text-accent-500 text-xl mb-2">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h4 class="text-sm font-bold text-white">Produk Original 100%</h4>
                    <p class="text-xs text-brand-200 mt-0.5">Jaminan mutu & tanggal kedaluwarsa aman</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-brand-800 flex items-center justify-center text-accent-500 text-xl mb-2">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <h4 class="text-sm font-bold text-white">Pengiriman Cepat</h4>
                    <p class="text-xs text-brand-200 mt-0.5">Antar 2 jam sampai ke alamat Anda</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-brand-800 flex items-center justify-center text-accent-500 text-xl mb-2">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <h4 class="text-sm font-bold text-white">Harga Hemat Minimarket</h4>
                    <p class="text-xs text-brand-200 mt-0.5">Banyak promo diskon & cashback</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-brand-800 flex items-center justify-center text-accent-500 text-xl mb-2">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h4 class="text-sm font-bold text-white">Layanan Pelanggan</h4>
                    <p class="text-xs text-brand-200 mt-0.5">Ramah & siap membantu setiap hari</p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center text-white font-black text-lg">
                        <i class="fa-solid fa-basket-shopping text-sm"></i>
                    </div>
                    <span class="font-black text-xl text-white">Toko Pak Imam</span>
                </div>
                <p class="text-xs text-gray-400 leading-relaxed mb-4">
                    Minimarket online belanja kebutuhan sehari-hari lengkap, murah, dan cepat. Belanja praktis tanpa keluar rumah bersama Toko Pak Imam!
                </p>
                <div class="flex space-x-3 text-gray-400">
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 hover:bg-brand-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-facebook-f text-xs"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 hover:bg-brand-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-instagram text-xs"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 hover:bg-brand-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-whatsapp text-xs"></i></a>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-bold text-white mb-4 uppercase tracking-wider">Kategori Terpopuler</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('products.index', ['category' => 'sembako']) }}" class="hover:text-brand-500 transition">Sembako & Beras</a></li>
                    <li><a href="{{ route('products.index', ['category' => 'makanan-instant']) }}" class="hover:text-brand-500 transition">Indomie & Makanan Instant</a></li>
                    <li><a href="{{ route('products.index', ['category' => 'minuman']) }}" class="hover:text-brand-500 transition">Minuman & Kopi</a></li>
                    <li><a href="{{ route('products.index', ['category' => 'susu-olahan']) }}" class="hover:text-brand-500 transition">Susu UHT & Steril</a></li>
                    <li><a href="{{ route('products.index', ['category' => 'perawatan-rumah']) }}" class="hover:text-brand-500 transition">Deterjen & Sabun Cuci</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-bold text-white mb-4 uppercase tracking-wider">Layanan Pelanggan</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#" class="hover:text-brand-500 transition">Cara Berbelanja</a></li>
                    <li><a href="#" class="hover:text-brand-500 transition">Metode Pembayaran COD & Transfer</a></li>
                    <li><a href="#" class="hover:text-brand-500 transition">Pengiriman & Area Layanan</a></li>
                    <li><a href="#" class="hover:text-brand-500 transition">Kebijakan Pengembalian Produk</a></li>
                    <li><a href="#" class="hover:text-brand-500 transition">Syarat & Ketentuan</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-bold text-white mb-4 uppercase tracking-wider">Hubungi Kami</h4>
                <div class="space-y-3 text-xs text-gray-400">
                    <p class="flex items-start gap-2">
                        <i class="fa-solid fa-location-dot mt-0.5 text-brand-500"></i>
                        <span>Jl. Raya Toko Pak Imam No. 88, Kebayoran Baru, Jakarta Selatan</span>
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fa-solid fa-phone text-brand-500"></i>
                        <span>(021) 555-PAKIMAM</span>
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fa-brands fa-whatsapp text-brand-500 text-sm"></i>
                        <span>+62 812-3456-7890</span>
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-brand-500"></i>
                        <span>cs@tokopakimam.com</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800 py-6 text-center text-xs text-gray-500">
            <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p>&copy; {{ date('Y') }} Toko Pak Imam. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex items-center space-x-3 text-lg text-gray-400">
                    <i class="fa-solid fa-money-bill-wave" title="COD / Tunai"></i>
                    <i class="fa-solid fa-building-columns" title="Transfer Bank"></i>
                    <i class="fa-solid fa-qrcode" title="QRIS"></i>
                    <i class="fa-solid fa-wallet" title="E-Wallet"></i>
                </div>
            </div>
        </div>
    </footer>

    <!-- MOBILE STICKY BOTTOM NAVIGATION BAR -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 flex items-center justify-around py-2 px-1 shadow-lg">
        <a href="{{ route('home') }}" class="flex flex-col items-center text-[10px] font-semibold {{ request()->routeIs('home') ? 'text-brand-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-house text-lg mb-0.5"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('products.index') }}" class="flex flex-col items-center text-[10px] font-semibold {{ request()->routeIs('products.*') ? 'text-brand-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-boxes-stacked text-lg mb-0.5"></i>
            <span>Kategori</span>
        </a>
        <a href="{{ route('cart.index') }}" class="flex flex-col items-center text-[10px] font-semibold relative {{ request()->routeIs('cart.*') ? 'text-brand-600' : 'text-gray-500' }}">
            <div class="relative">
                <i class="fa-solid fa-cart-shopping text-lg mb-0.5"></i>
                <span x-text="cartCount" x-show="cartCount > 0" class="absolute -top-1 -right-2 bg-red-500 text-white text-[9px] font-black w-4 h-4 rounded-full flex items-center justify-center"></span>
            </div>
            <span>Keranjang</span>
        </a>
        @auth
        <a href="{{ route('orders.index') }}" class="flex flex-col items-center text-[10px] font-semibold {{ request()->routeIs('orders.*') ? 'text-brand-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-receipt text-lg mb-0.5"></i>
            <span>Pesanan</span>
        </a>
        <a href="{{ route('customer.dashboard') }}" class="flex flex-col items-center text-[10px] font-semibold {{ request()->routeIs('customer.*') ? 'text-brand-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-user text-lg mb-0.5"></i>
            <span>Akun</span>
        </a>
        @else
        <a href="{{ route('login') }}" class="flex flex-col items-center text-[10px] font-semibold text-gray-500">
            <i class="fa-solid fa-right-to-bracket text-lg mb-0.5"></i>
            <span>Masuk</span>
        </a>
        @endauth
    </div>

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div id="toast-container" class="fixed bottom-20 right-4 md:bottom-6 md:right-6 z-50 space-y-2 pointer-events-none"></div>

    <script>
        function globalApp() {
            return {
                cartCount: {{ Auth::check() && Auth::user()->cart ? Auth::user()->cart->item_count : 0 }},
                showToast(message, type = 'success') {
                    const container = document.getElementById('toast-container');
                    const toast = document.createElement('div');
                    const isSuccess = type === 'success';
                    
                    toast.className = `pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-2xl shadow-2xl border text-xs font-semibold transition-all transform translate-y-2 opacity-0 ${
                        isSuccess ? 'bg-gray-900 text-white border-gray-800' : 'bg-rose-600 text-white border-rose-700'
                    }`;
                    toast.innerHTML = `
                        <i class="fa-solid ${isSuccess ? 'fa-circle-check text-emerald-400' : 'fa-circle-exclamation text-white'} text-base"></i>
                        <span>${message}</span>
                    `;

                    container.appendChild(toast);

                    setTimeout(() => {
                        toast.classList.remove('translate-y-2', 'opacity-0');
                    }, 50);

                    setTimeout(() => {
                        toast.classList.add('opacity-0', 'translate-y-2');
                        setTimeout(() => toast.remove(), 300);
                    }, 3500);
                }
            }
        }

        function searchAutocomplete() {
            return {
                query: '',
                open: false,
                loading: false,
                suggestions: { products: [], categories: [] },
                async fetchSuggestions() {
                    if (this.query.trim().length < 2) {
                        this.suggestions = { products: [], categories: [] };
                        return;
                    }
                    this.loading = true;
                    try {
                        const response = await fetch(`/api/products/autocomplete?q=${encodeURIComponent(this.query)}`);
                        const data = await response.json();
                        this.suggestions = data;
                    } catch (e) {
                        console.error(e);
                    } finally {
                        this.loading = false;
                    }
                },
                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
                }
            }
        }

        // Global Helper to add item to cart via Ajax
        async function addToCart(productId, quantity = 1) {
            try {
                const response = await fetch('{{ route("cart.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: productId, quantity: quantity })
                });

                const data = await response.json();
                
                if (data.success) {
                    const alpineApp = Alpine.raw(document.body._x_dataStack[0]);
                    if (alpineApp) {
                        alpineApp.cartCount = data.cartCount;
                        alpineApp.showToast(data.message, 'success');
                    }
                } else {
                    alert(data.message || 'Gagal menambahkan ke keranjang');
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan jaringan.');
            }
        }
    </script>
    @yield('scripts')
</body>
</html>
