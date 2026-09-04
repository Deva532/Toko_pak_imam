<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected function getOrCreateCart(Request $request)
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        } else {
            $sessionId = $request->session()->getId();
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        }

        return $cart;
    }

    public function index(Request $request)
    {
        $cart = $this->getOrCreateCart($request);
        $cart->load(['items.product.category']);

        return view('cart.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => "Stok {$product->name} tidak mencukupi (Tersisa {$product->stock})."], 422);
            }
            return back()->with('error', "Stok {$product->name} tidak mencukupi (Tersisa {$product->stock}).");
        }

        $cart = $this->getOrCreateCart($request);

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($product->stock < $newQuantity) {
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => "Stok {$product->name} tidak mencukupi untuk jumlah total ({$newQuantity})."], 422);
                }
                return back()->with('error', "Stok {$product->name} tidak mencukupi untuk jumlah total ({$newQuantity}).");
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        $cartCount = $cart->items()->sum('quantity');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$product->name} telah ditambahkan ke keranjang!",
                'cartCount' => $cartCount,
            ]);
        }

        return back()->with('success', "{$product->name} telah ditambahkan ke keranjang!");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cartItem = CartItem::with('product')->findOrFail($id);

        if ($cartItem->product->stock < $request->quantity) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => "Stok produk hanya tersisa {$cartItem->product->stock}."], 422);
            }
            return back()->with('error', "Stok produk hanya tersisa {$cartItem->product->stock}.");
        }

        $cartItem->update(['quantity' => $request->quantity]);

        $cart = $cartItem->cart;

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Jumlah produk diperbarui.',
                'itemSubtotal' => number_format($cartItem->subtotal, 0, ',', '.'),
                'cartSubtotal' => number_format($cart->subtotal, 0, ',', '.'),
                'cartCount' => $cart->item_count,
            ]);
        }

        return back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);
        $productName = $cartItem->product ? $cartItem->product->name : 'Produk';
        $cartItem->delete();

        if ($request->wantsJson()) {
            $cart = $this->getOrCreateCart($request);
            return response()->json([
                'success' => true,
                'message' => "{$productName} dihapus dari keranjang.",
                'cartCount' => $cart->item_count,
            ]);
        }

        return back()->with('success', "{$productName} berhasil dihapus dari keranjang.");
    }
}
