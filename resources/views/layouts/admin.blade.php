<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel | Toko Pak Imam')</title>

    <!-- Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js & Chart.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-100 flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col flex-shrink-0 min-h-screen">
        <!-- BRAND LOGO -->
        <div class="h-16 px-6 bg-slate-950 flex items-center justify-between border-b border-slate-800">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-green-600 flex items-center justify-center text-white font-black text-lg">
                    <i class="fa-solid fa-basket-shopping text-sm"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-black text-base text-white leading-tight">Toko Pak Imam</span>
                    <span class="text-[9px] font-semibold tracking-widest text-green-400 uppercase">Admin Console</span>
                </div>
            </a>
        </div>

        <!-- NAVIGATION LINKS -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 text-xs font-semibold">
            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider px-3 mb-2">Menu Utama</div>

            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-green-600 text-white shadow-md' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-chart-line text-sm w-4"></i>
                <span>Dashboard & Analytics</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.orders.*') ? 'bg-green-600 text-white shadow-md' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-cart-flatbed text-sm w-4"></i>
                <span>Kelola Pesanan</span>
            </a>

            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider px-3 mt-6 mb-2">Katalog & Stok</div>

            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.products.*') ? 'bg-green-600 text-white shadow-md' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-boxes-stacked text-sm w-4"></i>
                <span>Kelola Produk</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.categories.*') ? 'bg-green-600 text-white shadow-md' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-list text-sm w-4"></i>
                <span>Kategori Produk</span>
            </a>

            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider px-3 mt-6 mb-2">Sistem</div>

            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-store text-sm w-4"></i>
                <span>Lihat Website Customer <i class="fa-solid fa-arrow-up-right-from-square text-[10px] ml-1 opacity-70"></i></span>
            </a>
        </nav>

        <!-- ADMIN FOOTER -->
        <div class="p-4 border-t border-slate-800 bg-slate-950/50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center font-bold text-xs">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-400 truncate">Administrator</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN BODY -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- TOPBAR -->
        <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between sticky top-0 z-30 shadow-sm">
            <h1 class="text-base font-bold text-slate-900">@yield('page_header', 'Admin Dashboard')</h1>

            <div class="flex items-center space-x-4">
                <span class="text-xs bg-slate-100 text-slate-600 px-3 py-1.5 rounded-full font-semibold">
                    <i class="fa-regular fa-clock mr-1"></i> {{ date('d M Y, H:i') }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3.5 py-1.5 rounded-full transition">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
                    </button>
                </form>
            </div>
        </header>

        <!-- FLASH MESSAGES -->
        <div class="px-6 mt-4">
            @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 flex items-center justify-between text-xs font-semibold shadow-sm">
                <span class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-600 text-base"></i> {{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl p-4 flex items-center justify-between text-xs font-semibold shadow-sm">
                <span class="flex items-center gap-2"><i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i> {{ session('error') }}</span>
            </div>
            @endif
        </div>

        <!-- PAGE CONTENT -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
