@extends('layouts.app')

@section('title', 'Daftar Akun Baru | Toko Pak Imam')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-brand-600 rounded-2xl flex items-center justify-center text-white text-2xl font-black mx-auto mb-3 shadow-md">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-900">Daftar Akun Toko Pak Imam</h2>
            <p class="text-xs text-gray-500 mt-1">Dapatkan promo menarik dan gratis ongkir setiap hari</p>
        </div>

        @if ($errors->any())
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-2xl text-xs font-semibold space-y-1">
            @foreach ($errors->all() as $error)
                <p><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap</label>
                <div class="relative">
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="contoh: Budi Santoso" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-xs focus:ring-2 focus:ring-brand-500 focus:bg-white focus:outline-none transition">
                    <i class="fa-solid fa-user absolute left-3.5 top-3 text-gray-400 text-xs"></i>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Email</label>
                <div class="relative">
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh: budi@gmail.com" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-xs focus:ring-2 focus:ring-brand-500 focus:bg-white focus:outline-none transition">
                    <i class="fa-solid fa-envelope absolute left-3.5 top-3 text-gray-400 text-xs"></i>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Nomor WhatsApp / HP</label>
                <div class="relative">
                    <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="contoh: 081234567890" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-xs focus:ring-2 focus:ring-brand-500 focus:bg-white focus:outline-none transition">
                    <i class="fa-solid fa-phone absolute left-3.5 top-3 text-gray-400 text-xs"></i>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-xs focus:ring-2 focus:ring-brand-500 focus:bg-white focus:outline-none transition">
                    <i class="fa-solid fa-lock absolute left-3.5 top-3 text-gray-400 text-xs"></i>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Konfirmasi Password</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password di atas" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-xs focus:ring-2 focus:ring-brand-500 focus:bg-white focus:outline-none transition">
                    <i class="fa-solid fa-shield-check absolute left-3.5 top-3 text-gray-400 text-xs"></i>
                </div>
            </div>

            <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm py-3 rounded-xl shadow-md transition transform active:scale-95 mt-2">
                Daftar Akun
            </button>
        </form>

        <div class="mt-6 text-center text-xs text-gray-500">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="text-brand-600 font-bold hover:underline">Masuk Sekarang</a>
        </div>
    </div>
</div>
@endsection
