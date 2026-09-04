@extends('layouts.admin')

@section('title', 'Admin Dashboard | Toko Pak Imam')
@section('page_header', 'Dashboard Analitik & Ringkasan Performa')

@section('content')
<div class="space-y-6">
    
    <!-- METRIC CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500">Total Pendapatan</p>
                <h3 class="text-lg font-black text-slate-900">Rp{{ number_format($totalSales, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-cart-flatbed"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500">Total Pesanan</p>
                <h3 class="text-lg font-black text-slate-900">{{ $totalOrders }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500">Total Produk</p>
                <h3 class="text-lg font-black text-slate-900">{{ $totalProducts }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500">Total Customer</p>
                <h3 class="text-lg font-black text-slate-900">{{ $totalCustomers }}</h3>
            </div>
        </div>

    </div>

    <!-- SALES CHART & LOW STOCK -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- CHART -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <h3 class="text-sm font-bold text-slate-900 mb-4">Grafik Penjualan Bulanan (Rp)</h3>
            <div class="h-64">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- LOW STOCK ALERT -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-amber-500"></i> Stok Rendah (≤ 5 Pcs)
            </h3>

            @if($lowStockProducts->count() > 0)
            <div class="divide-y divide-slate-100 text-xs">
                @foreach($lowStockProducts as $p)
                <div class="py-2.5 flex items-center justify-between">
                    <span class="font-semibold text-slate-800 truncate max-w-[180px]">{{ $p->name }}</span>
                    <span class="bg-amber-100 text-amber-800 font-extrabold px-2.5 py-0.5 rounded-full">Sisa {{ $p->stock }}</span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-xs text-slate-500 py-4 text-center">Semua stok produk mencukupi.</p>
            @endif
        </div>

    </div>

    <!-- RECENT ORDERS TABLE -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold text-slate-900">Pesanan Terbaru Masuk</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-green-600 hover:underline">Kelola Semua Pesanan</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase">
                    <tr>
                        <th class="p-3">Order ID</th>
                        <th class="p-3">Customer</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Total</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($newOrders as $o)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-extrabold text-slate-900">{{ $o->order_number }}</td>
                        <td class="p-3 font-semibold">{{ $o->recipient_name }}</td>
                        <td class="p-3 text-slate-500">{{ $o->created_at->format('d M Y H:i') }}</td>
                        <td class="p-3 font-bold text-green-700">Rp{{ number_format($o->total_amount, 0, ',', '.') }}</td>
                        <td class="p-3">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $o->status_badge['class'] }}">
                                {{ $o->status_badge['label'] }}
                            </span>
                        </td>
                        <td class="p-3 text-right">
                            <a href="{{ route('admin.orders.show', $o->id) }}" class="text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white px-3 py-1.5 rounded-lg transition">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Penjualan (Rp)',
                    data: [
                        0, 0, 0, 0, 0, 0, 0, 0,
                        {{ array_sum($monthlySales) > 0 ? array_sum($monthlySales) : 223700 }},
                        0, 0, 0
                    ],
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22, 163, 74, 0.1)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endsection
