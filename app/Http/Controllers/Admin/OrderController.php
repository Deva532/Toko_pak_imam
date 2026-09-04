<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('order_number', 'like', "%{$keyword}%")
                  ->orWhere('recipient_name', 'like', "%{$keyword}%")
                  ->orWhere('phone', 'like', "%{$keyword}%");
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'shippingMethod', 'payment'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => ['required', 'in:pending,waiting_payment,paid,processing,shipped,completed,cancelled'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
            'courier_name' => ['nullable', 'string', 'max:100'],
        ]);

        $data = [
            'status' => $request->status,
        ];

        if ($request->filled('tracking_number')) {
            $data['tracking_number'] = $request->tracking_number;
        }

        if ($request->filled('courier_name')) {
            $data['courier_name'] = $request->courier_name;
        }

        $order->update($data);

        if ($order->payment && $request->status === 'paid') {
            $order->payment->update(['payment_status' => 'paid', 'paid_at' => now()]);
        }

        return back()->with('success', "Status pesanan {$order->order_number} berhasil diperbarui menjadi " . strtoupper($request->status));
    }
}
