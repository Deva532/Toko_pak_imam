<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        // Validate stock
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')->with('error', "Stok produk '{$item->product->name}' tidak mencukupi (Tersisa {$item->product->stock}).");
            }
        }

        $addresses = Address::where('user_id', $user->id)->get();
        $defaultAddress = $addresses->where('is_default', true)->first() ?? $addresses->first();
        $shippingMethods = ShippingMethod::where('is_active', true)->get();

        return view('checkout.index', compact('cart', 'addresses', 'defaultAddress', 'shippingMethods'));
    }

    public function process(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $request->validate([
            'address_id' => ['required', 'exists:addresses,id'],
            'shipping_method_id' => ['required', 'exists:shipping_methods,id'],
            'payment_method' => ['required', 'in:cod,bank_transfer,qris,ewallet'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $address = Address::where('user_id', $user->id)->findOrFail($request->address_id);
        $shippingMethod = ShippingMethod::findOrFail($request->shipping_method_id);

        return DB::transaction(function () use ($request, $user, $cart, $address, $shippingMethod) {
            // Re-validate stock
            foreach ($cart->items as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Stok produk '{$item->product->name}' tidak mencukupi (Tersisa {$item->product->stock}).");
                }
            }

            $subtotal = $cart->subtotal;
            $shippingCost = $shippingMethod->cost;
            $totalAmount = $subtotal + $shippingCost;

            $orderNumber = 'TPI-' . strtoupper(Str::random(3)) . '-' . date('YmdHis');
            $status = ($request->payment_method === 'cod') ? 'processing' : 'waiting_payment';

            $fullAddress = "{$address->recipient_name} ({$address->phone}) - {$address->address}, Kel/Kec. {$address->district}, {$address->city}, {$address->province} {$address->postal_code}";

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'recipient_name' => $address->recipient_name,
                'phone' => $address->phone,
                'address_text' => $fullAddress,
                'shipping_method_id' => $shippingMethod->id,
                'shipping_cost' => $shippingCost,
                'subtotal' => $subtotal,
                'discount_amount' => 0,
                'total_amount' => $totalAmount,
                'status' => $status,
                'courier_name' => $shippingMethod->name,
                'notes' => $request->notes,
            ]);

            // Save order items & decrement stock
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->effective_price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ]);

                // Update stock and sold_count
                $item->product->decrement('stock', $item->quantity);
                $item->product->increment('sold_count', $item->quantity);
            }

            // Create Payment record
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'payment_status' => ($request->payment_method === 'cod') ? 'unpaid' : 'unpaid',
            ]);

            // Clear Cart
            $cart->items()->delete();

            return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan Anda berhasil dibuat! Silakan ikuti instruksi pembayaran di bawah ini.');
        });
    }
}
