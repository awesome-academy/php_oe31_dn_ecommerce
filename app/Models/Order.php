<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_infor_id',
        'status',
        'order_code',
        'total_price',
    ];

    /**
     * Define order's status
     */
    const PENDING = 1;
    const SUCCESS = 2;
    const CANCEL = 3;

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

    /**
     * Get the order informations associated with the order.
     */
    public function order_infors()
    {
        return $this->hasOne(OrderInfor::class, 'id', 'order_infor_id');
    }

    /**
     * @param $date
     * @return string
     */
    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');
    }

    /**
     * @param $date
     * @return string
     */
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');
    }
}
