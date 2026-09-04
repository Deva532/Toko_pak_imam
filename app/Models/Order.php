<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'recipient_name',
        'phone',
        'address_text',
        'shipping_method_id',
        'shipping_cost',
        'subtotal',
        'discount_amount',
        'total_amount',
        'status',
        'courier_name',
        'tracking_number',
        'notes',
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => ['label' => 'Menunggu', 'class' => 'bg-amber-100 text-amber-800 border-amber-200'],
            'waiting_payment' => ['label' => 'Belum Dibayar', 'class' => 'bg-orange-100 text-orange-800 border-orange-200'],
            'paid' => ['label' => 'Sudah Dibayar', 'class' => 'bg-emerald-100 text-emerald-800 border-emerald-200'],
            'processing' => ['label' => 'Diproses', 'class' => 'bg-blue-100 text-blue-800 border-blue-200'],
            'shipped' => ['label' => 'Dikirim', 'class' => 'bg-indigo-100 text-indigo-800 border-indigo-200'],
            'completed' => ['label' => 'Selesai', 'class' => 'bg-green-100 text-green-800 border-green-200'],
            'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-rose-100 text-rose-800 border-rose-200'],
            default => ['label' => $this->status, 'class' => 'bg-slate-100 text-slate-800 border-slate-200'],
        };
    }
}
