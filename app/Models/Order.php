<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'order_code',
    ];

    /**
     * Define order's status
     */
    const PENDING = 1;
    const SUCCESS = 2;

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The order details that belong to the order.
     */
    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
