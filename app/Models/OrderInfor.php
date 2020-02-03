<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderInfor extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'city_id',
    ];

    /**
     * Get the order that owns the order information.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the city that owns the order information.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
