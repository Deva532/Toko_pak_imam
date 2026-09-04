@extends('layouts.app')

@section('title', 'Akses Ditolak (403) | Toko Pak Imam')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4 py-12">
    <div class="text-center max-w-md bg-white p-8 sm:p-12 rounded-3xl border border-gray-100 shadow-xl space-y-4">
        <div class="w-20 h-20 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-2">
            <i class="fa-solid fa-lock"></i>
        </div>
        <h1 class="text-3xl font-black text-gray-900">403</h1>
        <h2 class="text-base font-bold text-gray-800">Akses Ditolak</h2>
        <p class="text-xs text-gray-500 leading-relaxed">Anda tidak memiliki hak akses untuk membuka halaman ini. Halaman ini khusus untuk Administrator Toko Pak Imam.</p>
        <div class="pt-4">
            <a href="{{ route('home') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs px-6 py-3 rounded-full shadow-md inline-block transition">
                <i class="fa-solid fa-house mr-1"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
