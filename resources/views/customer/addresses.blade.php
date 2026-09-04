@extends('layouts.app')

@section('title', 'Buku Alamat | Toko Pak Imam')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ addModal: false }">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        
        <!-- SIDEBAR MENU -->
        <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm h-fit space-y-2 text-xs font-bold">
            <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-gray-700 hover:bg-gray-100 transition">
                <i class="fa-solid fa-gauge-high text-sm w-4"></i> Dashboard Akun
            </a>
            <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-gray-700 hover:bg-gray-100 transition">
                <i class="fa-solid fa-box-open text-sm w-4"></i> Pesanan Saya
            </a>
            <a href="{{ route('customer.addresses') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl bg-brand-600 text-white shadow-sm">
                <i class="fa-solid fa-location-dot text-sm w-4"></i> Buku Alamat
            </a>
            <a href="{{ route('customer.wishlist') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-gray-700 hover:bg-gray-100 transition">
                <i class="fa-solid fa-heart text-sm w-4"></i> Wishlist Saya
            </a>
            <a href="{{ route('customer.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-gray-700 hover:bg-gray-100 transition">
                <i class="fa-solid fa-user-gear text-sm w-4"></i> Pengaturan Profil
            </a>
        </div>

        <!-- MAIN ADDRESS LIST -->
        <div class="md:col-span-3">
            <div class="bg-white rounded-3xl border border-gray-100 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center justify-between mb-6 pb-3 border-b border-gray-100">
                    <h3 class="text-base font-extrabold text-gray-900">Daftar Alamat Pengiriman</h3>
                    <button @click="addModal = true" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs px-4 py-2 rounded-xl shadow-sm transition">
                        + Tambah Alamat Baru
                    </button>
                </div>

                @if($addresses->count() > 0)
                <div class="space-y-4">
                    @foreach($addresses as $addr)
                    <div class="p-5 rounded-2xl border border-gray-200 flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        <div class="space-y-1 text-xs text-gray-700">
                            <div class="flex items-center gap-2">
                                <span class="font-extrabold text-sm text-gray-900">{{ $addr->label }}</span>
                                @if($addr->is_default)
                                <span class="bg-brand-100 text-brand-700 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase">Alamat Utama</span>
                                @endif
                            </div>
                            <p class="font-bold text-gray-900">{{ $addr->recipient_name }} ({{ $addr->phone }})</p>
                            <p class="leading-relaxed text-gray-600">{{ $addr->address }}, Kel/Kec. {{ $addr->district }}, {{ $addr->city }}, {{ $addr->province }} {{ $addr->postal_code }}</p>
                            @if($addr->note)
                            <p class="text-[11px] text-gray-400 italic"><i class="fa-regular fa-note-sticky mr-1"></i> {{ $addr->note }}</p>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('customer.addresses.destroy', $addr->id) }}" onsubmit="return confirm('Hapus alamat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs font-bold p-1">
                                <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-xs text-gray-500 py-6 text-center">Belum ada alamat tersimpan.</p>
                @endif
            </div>
        </div>

    </div>

    <!-- ADD ADDRESS MODAL -->
    <div x-show="addModal" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="text-sm font-extrabold text-gray-900">Tambah Alamat Pengiriman Baru</h3>
                <button @click="addModal = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form method="POST" action="{{ route('customer.addresses.store') }}" class="space-y-4 text-xs">
                @csrf

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Label Alamat (Contoh: Rumah, Kantor)</label>
                    <input type="text" name="label" required placeholder="Rumah" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Nama Penerima</label>
                        <input type="text" name="recipient_name" required placeholder="Budi Santoso" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Nomor HP Penerima</label>
                        <input type="text" name="phone" required placeholder="081234567890" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Alamat Lengkap (Jalan, No. Rumah, RT/RW)</label>
                    <textarea name="address" rows="2" required placeholder="Jl. Merdeka No. 45" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:ring-2 focus:ring-brand-500 focus:outline-none"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Kecamatan / Kelurahan</label>
                        <input type="text" name="district" required placeholder="Kebayoran Baru" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Kota / Kabupaten</label>
                        <input type="text" name="city" required placeholder="Jakarta Selatan" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Provinsi</label>
                        <input type="text" name="province" required placeholder="DKI Jakarta" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" name="postal_code" required placeholder="12110" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Catatan Patokan (Opsional)</label>
                    <input type="text" name="note" placeholder="Pagar warna hijau" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>

                <label class="flex items-center text-gray-700 font-bold cursor-pointer">
                    <input type="checkbox" name="is_default" value="1" class="rounded text-brand-600 focus:ring-brand-500 mr-2">
                    Jadikan Alamat Utama
                </label>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                    <button type="button" @click="addModal = false" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2 font-bold bg-brand-600 hover:bg-brand-700 text-white rounded-xl shadow-md transition">Simpan Alamat</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
