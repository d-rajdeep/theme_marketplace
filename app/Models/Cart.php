<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
    ];

    // Cart belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Cart has many cart items
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Helper: get total price of all items in cart
    public function total(): float
    {
        return $this->items->sum('price');
    }

    // Helper: count items in cart
    public function itemCount(): int
    {
        return $this->items->count();
    }
}
