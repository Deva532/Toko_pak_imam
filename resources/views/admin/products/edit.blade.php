@extends('layouts.admin')

@section('title', "Edit Produk {$product->name} | Admin Toko Pak Imam")
@section('page_header', "Edit Produk: {$product->name}")

@section('content')
<div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm max-w-4xl">
    
    @if ($errors->any())
    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-xl text-xs font-semibold space-y-1">
        @foreach ($errors->all() as $error)
            <p><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" class="space-y-6 text-xs">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>
            <div>
                <label class="block font-bold text-slate-700 mb-1">SKU Produk</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 font-mono focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 mb-1">Kategori</label>
                <select name="category_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ old('category_id', $product->category_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-bold text-slate-700 mb-1">Brand / Merek</label>
                <select name="brand_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    <option value="">-- Tanpa Brand --</option>
                    @foreach($brands as $b)
                    <option value="{{ $b->id }}" {{ old('brand_id', $product->brand_id) == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block font-bold text-slate-700 mb-1">Harga Normal (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>
            <div>
                <label class="block font-bold text-slate-700 mb-1">Harga Diskon (Rp)</label>
                <input type="number" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>
            <div>
                <label class="block font-bold text-slate-700 mb-1">Jumlah Stok (Pcs)</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-slate-700 mb-1">Berat Produk (Gram)</label>
                <input type="number" name="weight" value="{{ old('weight', $product->weight) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>
            <div>
                <label class="block font-bold text-slate-700 mb-1">Ubah Foto Utama (Opsional)</label>
                <input type="file" name="main_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
            </div>
        </div>

        <div>
            <label class="block font-bold text-slate-700 mb-1">Deskripsi Lengkap Produk</label>
            <textarea name="description" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="flex flex-wrap gap-4 pt-2 border-t border-slate-100 font-bold">
            <label class="flex items-center text-slate-700 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="rounded text-green-600 focus:ring-green-500 mr-2">
                Status Produk Aktif
            </label>
            <label class="flex items-center text-slate-700 cursor-pointer">
                <input type="checkbox" name="is_promo" value="1" {{ $product->is_promo ? 'checked' : '' }} class="rounded text-green-600 focus:ring-green-500 mr-2">
                Produk Promo Diskon
            </label>
            <label class="flex items-center text-slate-700 cursor-pointer">
                <input type="checkbox" name="is_best_seller" value="1" {{ $product->is_best_seller ? 'checked' : '' }} class="rounded text-green-600 focus:ring-green-500 mr-2">
                Produk Terlaris
            </label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-green-600 hover:bg-green-700 text-white font-bold shadow-md">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
