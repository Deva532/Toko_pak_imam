@extends('layouts.admin')

@section('title', 'Kategori Produk | Admin Toko Pak Imam')
@section('page_header', 'Kelola Kategori Produk')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="{ editModal: false, activeCat: {} }">
    
    <!-- ADD CATEGORY FORM -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm h-fit space-y-4 text-xs">
        <h3 class="text-sm font-extrabold text-slate-900 pb-3 border-b border-slate-100">Tambah Kategori Baru</h3>

        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Kategori</label>
                <input type="text" name="name" required placeholder="Contoh: Sembako" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Ikon (FontAwesome)</label>
                <input type="text" name="icon" placeholder="shopping-bag" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Urutan Tampil (Sort Order)</label>
                <input type="number" name="sort_order" value="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 rounded-xl shadow-md transition">
                + Simpan Kategori
            </button>
        </form>
    </div>

    <!-- CATEGORIES LIST TABLE -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase">
                <tr>
                    <th class="p-3">Urutan</th>
                    <th class="p-3">Nama Kategori</th>
                    <th class="p-3">Slug</th>
                    <th class="p-3">Jumlah Produk</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($categories as $cat)
                <tr class="hover:bg-slate-50">
                    <td class="p-3 font-bold text-slate-600">{{ $cat->sort_order }}</td>
                    <td class="p-3 font-extrabold text-slate-900">{{ $cat->name }}</td>
                    <td class="p-3 font-mono text-slate-500">{{ $cat->slug }}</td>
                    <td class="p-3 font-bold text-slate-800">{{ $cat->products_count }} Produk</td>
                    <td class="p-3">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $cat->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                            {{ $cat->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="p-3 text-right">
                        <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}" onsubmit="return confirm('Hapus kategori ini?')" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 px-2.5 py-1.5 rounded-lg transition">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
