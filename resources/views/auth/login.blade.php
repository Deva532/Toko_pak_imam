@extends('layouts.app')

@section('title', 'Masuk Akun | Toko Pak Imam')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-brand-600 rounded-2xl flex items-center justify-center text-white text-2xl font-black mx-auto mb-3 shadow-md">
                <i class="fa-solid fa-basket-shopping"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-900">Masuk ke Toko Pak Imam</h2>
            <p class="text-xs text-gray-500 mt-1">Belanja kebutuhan harian praktis, murah, dan cepat</p>
        </div>

        @if ($errors->any())
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-2xl text-xs font-semibold space-y-1">
            @foreach ($errors->all() as $error)
                <p><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Email</label>
                <div class="relative">
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="contoh: customer@tokopakimam.com" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-xs focus:ring-2 focus:ring-brand-500 focus:bg-white focus:outline-none transition">
                    <i class="fa-solid fa-envelope absolute left-3.5 top-3 text-gray-400 text-xs"></i>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" required placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-xs focus:ring-2 focus:ring-brand-500 focus:bg-white focus:outline-none transition">
                    <i class="fa-solid fa-lock absolute left-3.5 top-3 text-gray-400 text-xs"></i>
                </div>
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center text-gray-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-brand-600 focus:ring-brand-500 mr-2">
                    Ingat Saya
                </label>
                <a href="#" class="text-brand-600 font-semibold hover:underline">Lupa Password?</a>
            </div>

            <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm py-3 rounded-xl shadow-md transition transform active:scale-95">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-6 text-center text-xs text-gray-500">
            Belum punya akun Toko Pak Imam? 
            <a href="{{ route('register') }}" class="text-brand-600 font-bold hover:underline">Daftar Akun Baru</a>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-[11px] text-gray-400 font-medium">Akun Demo untuk Pengujian:</p>
            <div class="mt-2 text-[11px] text-gray-600 space-y-1">
                <p><strong>Admin:</strong> admin@tokopakimam.com / password</p>
                <p><strong>Customer:</strong> customer@tokopakimam.com / password</p>
            </div>
        </div>
    </div>
</div>
@endsection
