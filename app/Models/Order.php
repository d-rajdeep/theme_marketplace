<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'razorpay_order_id',
        'razorpay_payment_id',
    ];

    // Order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Order has many order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Order belongs to many products (through order_items)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
            ->withPivot('price')
            ->withTimestamps();
    }

    // Helper: check if order is paid
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    // Auto-generate order number before creating
    protected static function booted(): void
    {
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . strtoupper(uniqid());
        });
    }
}
