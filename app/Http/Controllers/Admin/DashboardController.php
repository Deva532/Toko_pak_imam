<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::whereIn('status', ['paid', 'processing', 'shipped', 'completed'])->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();

        $newOrders = Order::latest()->take(5)->with('user')->get();
        $lowStockProducts = Product::where('stock', '<=', 5)->where('is_active', true)->take(5)->get();

        // Monthly sales data for chart
        $monthlySales = Order::select(
            DB::raw('strftime("%m", created_at) as month'),
            DB::raw('SUM(total_amount) as total')
        )
        ->whereIn('status', ['paid', 'processing', 'shipped', 'completed'])
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month')
        ->toArray();

        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'newOrders',
            'lowStockProducts',
            'monthlySales'
        ));
    }
}
