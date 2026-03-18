<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // One user has one cart
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    // One user has many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Helper: check if user is admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
