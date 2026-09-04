<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->take(12)
            ->get();

        $promoProducts = Product::where('is_active', true)
            ->where('is_promo', true)
            ->where('stock', '>', 0)
            ->with(['category', 'brand'])
            ->latest()
            ->take(8)
            ->get();

        $bestSellers = Product::where('is_active', true)
            ->where('is_best_seller', true)
            ->where('stock', '>', 0)
            ->with(['category', 'brand'])
            ->orderBy('sold_count', 'desc')
            ->take(8)
            ->get();

        $recommendedProducts = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->with(['category', 'brand'])
            ->inRandomOrder()
            ->take(12)
            ->get();

        return view('home', compact(
            'categories',
            'promoProducts',
            'bestSellers',
            'recommendedProducts'
        ));
    }
}
