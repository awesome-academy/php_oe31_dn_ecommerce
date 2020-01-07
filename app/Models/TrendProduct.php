<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrendProduct extends Model
{
    protected $table = 'product_trends';

    protected $fillable = [
        'trend_id',
        'product_id',
    ];
}
