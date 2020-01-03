<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'name',
        'type',
        'product_id',
    ];

    /**
     * Define product's image type
     */
    const FIRST = 1;
    const CHILD = 2;

    /**
     * Get the product that owns the image.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
