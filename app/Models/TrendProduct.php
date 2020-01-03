<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrendProduct extends Model
{
    protected $fillable = [
        'trend_id',
        'product_id',
    ];
}
