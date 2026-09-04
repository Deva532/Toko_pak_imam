<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        $query = Order::where('user_id', Auth::id())->with(['items.product', 'payment']);

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('orders.index', compact('orders', 'status'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['items.product', 'shippingMethod', 'payment'])
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function uploadPaymentProof(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'proof_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        if ($request->hasFile('proof_image')) {
            $path = $request->file('proof_image')->store('payment_proofs', 'public');
            
            $payment = $order->payment ?? Payment::create(['order_id' => $order->id, 'payment_method' => 'bank_transfer']);
            $payment->update([
                'proof_image' => $path,
            ]);

            if ($order->status === 'waiting_payment') {
                $order->update(['status' => 'paid']);
            }

            return back()->with('success', 'Bukti pembayaran berhasil diunggah! Tim Toko Pak Imam akan memverifikasi pesanan Anda.');
        }

        return back()->with('error', 'Gagal mengunggah gambar.');
    }

    public function cancel(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if (! in_array($order->status, ['pending', 'waiting_payment'])) {
            return back()->with('error', 'Pesanan ini sudah tidak dapat dibatalkan.');
        }

        // Restore stock
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->quantity);
                $item->product->decrement('sold_count', $item->quantity);
            }
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function printInvoice($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['items.product', 'shippingMethod', 'payment', 'user'])
            ->findOrFail($id);

        return view('orders.invoice', compact('order'));
    }
}
