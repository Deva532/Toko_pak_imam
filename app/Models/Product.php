<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'weight',
        'category_id',
        'brand_id',
        'main_image',
        'is_active',
        'is_featured',
        'is_promo',
        'is_best_seller',
        'rating',
        'sold_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_promo' => 'boolean',
        'is_best_seller' => 'boolean',
        'rating' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order', 'asc');
    }

    public function getEffectivePriceAttribute()
    {
        return ($this->discount_price && $this->discount_price > 0 && $this->discount_price < $this->price)
            ? $this->discount_price
            : $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->discount_price && $this->discount_price > 0 && $this->discount_price < $this->price) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
