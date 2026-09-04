@extends('layouts.admin')

@section('title', 'Kelola Produk | Admin Toko Pak Imam')
@section('page_header', 'Kelola Katalog Produk')

@section('content')
<div class="space-y-6">
    
    <!-- TOP TOOLBAR -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau SKU..." class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-xs focus:ring-2 focus:ring-green-500 focus:outline-none">
            
            <select name="category_id" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-xs font-semibold focus:ring-2 focus:ring-green-500 focus:outline-none">
                <option value="">Semua Kategori</option>
                @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-slate-900 text-white font-bold text-xs px-4 py-1.5 rounded-xl">Filter</button>
        </form>

        <a href="{{ route('admin.products.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold text-xs px-4 py-2 rounded-xl shadow-md transition text-center">
            + Tambah Produk Baru
        </a>
    </div>

    <!-- PRODUCTS TABLE -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase">
                <tr>
                    <th class="p-3">Foto & Nama Produk</th>
                    <th class="p-3">SKU</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Harga Normal / Diskon</th>
                    <th class="p-3">Stok</th>
                    <th class="p-3">Status / Badge</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($products as $p)
                <tr class="hover:bg-slate-50">
                    <td class="p-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $p->main_image }}" class="w-10 h-10 object-cover rounded-lg border border-slate-200 flex-shrink-0">
                            <div>
                                <p class="font-bold text-slate-900">{{ $p->name }}</p>
                                <p class="text-[10px] text-slate-400">Terjual {{ $p->sold_count }} Pcs</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-3 font-mono font-bold text-slate-600">{{ $p->sku }}</td>
                    <td class="p-3 font-semibold text-slate-700">{{ $p->category->name }}</td>
                    <td class="p-3 font-bold text-slate-900">
                        Rp{{ number_format($p->price, 0, ',', '.') }}
                        @if($p->discount_price)
                        <span class="block text-[10px] text-rose-600 line-through">Rp{{ number_format($p->discount_price, 0, ',', '.') }}</span>
                        @endif
                    </td>
                    <td class="p-3">
                        <span class="font-bold {{ $p->stock <= 5 ? 'text-amber-600' : 'text-emerald-600' }}">{{ $p->stock }} Pcs</span>
                    </td>
                    <td class="p-3">
                        <div class="flex flex-wrap gap-1">
                            @if($p->is_promo)
                            <span class="bg-red-100 text-red-700 text-[9px] font-bold px-2 py-0.5 rounded-full">Promo</span>
                            @endif
                            @if($p->is_best_seller)
                            <span class="bg-amber-100 text-amber-800 text-[9px] font-bold px-2 py-0.5 rounded-full">Terlaris</span>
                            @endif
                            @if($p->is_active)
                            <span class="bg-emerald-100 text-emerald-800 text-[9px] font-bold px-2 py-0.5 rounded-full">Aktif</span>
                            @else
                            <span class="bg-slate-100 text-slate-500 text-[9px] font-bold px-2 py-0.5 rounded-full">Nonaktif</span>
                            @endif
                        </div>
                    </td>
                    <td class="p-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $p->id) }}" class="text-xs font-bold bg-blue-50 text-blue-600 hover:bg-blue-100 px-2.5 py-1.5 rounded-lg transition">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $p->id) }}" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 px-2.5 py-1.5 rounded-lg transition">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
