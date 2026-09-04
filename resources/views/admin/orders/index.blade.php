@extends('layouts.admin')

@section('title', 'Kelola Pesanan | Admin Toko Pak Imam')
@section('page_header', 'Manajemen Pesanan Masuk')

@section('content')
<div class="space-y-6">
    
    <!-- TOP TOOLBAR -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Order ID, Nama, No. HP..." class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 focus:ring-2 focus:ring-green-500 focus:outline-none">
            
            <select name="status" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 font-semibold focus:ring-2 focus:ring-green-500 focus:outline-none">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="waiting_payment" {{ request('status') === 'waiting_payment' ? 'selected' : '' }}>Belum Dibayar</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Diproses / Dikemas</option>
                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Dikirim</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>

            <button type="submit" class="bg-slate-900 text-white font-bold px-4 py-1.5 rounded-xl">Filter</button>
        </form>
    </div>

    <!-- ORDERS TABLE -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase">
                <tr>
                    <th class="p-3">Order ID</th>
                    <th class="p-3">Customer & Kontak</th>
                    <th class="p-3">Tanggal Pesanan</th>
                    <th class="p-3">Metode Bayar</th>
                    <th class="p-3">Total Tagihan</th>
                    <th class="p-3">Status Pesanan</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($orders as $o)
                <tr class="hover:bg-slate-50">
                    <td class="p-3 font-extrabold text-slate-900">{{ $o->order_number }}</td>
                    <td class="p-3">
                        <p class="font-bold text-slate-900">{{ $o->recipient_name }}</p>
                        <p class="text-[10px] text-slate-400">{{ $o->phone }}</p>
                    </td>
                    <td class="p-3 text-slate-500">{{ $o->created_at->format('d M Y H:i') }}</td>
                    <td class="p-3 font-bold uppercase text-slate-700">{{ $o->payment ? $o->payment->payment_method : 'COD' }}</td>
                    <td class="p-3 font-black text-green-700">Rp{{ number_format($o->total_amount, 0, ',', '.') }}</td>
                    <td class="p-3">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $o->status_badge['class'] }}">
                            {{ $o->status_badge['label'] }}
                        </span>
                    </td>
                    <td class="p-3 text-right">
                        <a href="{{ route('admin.orders.show', $o->id) }}" class="text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white px-3 py-1.5 rounded-lg transition">
                            Kelola
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
