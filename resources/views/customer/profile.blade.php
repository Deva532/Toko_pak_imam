@extends('layouts.app')

@section('title', 'Pengaturan Profil | Toko Pak Imam')

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
            <a href="{{ route('customer.wishlist') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-gray-700 hover:bg-gray-100 transition">
                <i class="fa-solid fa-heart text-sm w-4"></i> Wishlist Saya
            </a>
            <a href="{{ route('customer.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl bg-brand-600 text-white shadow-sm">
                <i class="fa-solid fa-user-gear text-sm w-4"></i> Pengaturan Profil
            </a>
        </div>

        <!-- MAIN FORM -->
        <div class="md:col-span-3">
            <div class="bg-white rounded-3xl border border-gray-100 p-6 sm:p-8 shadow-sm">
                <h3 class="text-base font-extrabold text-gray-900 mb-6 pb-3 border-b border-gray-100">Ubah Profil & Password</h3>

                <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-5 max-w-xl">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nomor WhatsApp / HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Password Baru (Biarkan kosong jika tidak diubah)</label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs px-6 py-3 rounded-xl shadow-md transition">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
