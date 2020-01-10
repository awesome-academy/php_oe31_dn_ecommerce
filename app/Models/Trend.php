<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trend extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
    ];

    /**
     * Get the products for the trend.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_trends');
    }
}
