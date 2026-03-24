<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'type',
        'status',
        'demo_url',
        'thumbnail',
        'file_path'
    ];

    // Product belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Product has many images
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Product has one primary image
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    // Product belongs to many orders (through order_items)
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('price')
            ->withTimestamps();
    }

    // Scope: only active products
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }
}
