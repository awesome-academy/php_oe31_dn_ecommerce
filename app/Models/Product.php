<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'sale_price',
        'sale_percent',
        'quantity',
        'image',
        'category_id',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the images for the product.
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Get first image
     */
    public function first_image()
    {
        return $this->hasOne(Image::class)->where('type', '=', Image::FIRST);
    }

    /**
     * Get the ratings for the product.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get the comments for the product.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('id', 'DESC');
    }

    /**
     * Get the order details for the product.
     */
    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Get the trend products for the product.
     */
    public function trends()
    {
        return $this->belongsToMany(Trend::class, 'product_trends');
    }
}
