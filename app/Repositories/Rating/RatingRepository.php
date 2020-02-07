<?php

namespace App\Repositories\Rating;

use App\Models\Order;
use App\Models\Rating;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class RatingRepository extends BaseRepository implements RatingRepositoryInterface
{
    public function getModel()
    {
        return Rating::class;
    }

    public function checkOrderSuccess($product_id)
    {
        return DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.user_id', '=', auth()->user()->id)
            ->where('orders.status', '=', Order::SUCCESS)
            ->where('order_details.product_id', '=', $product_id)
            ->count();
    }

    public function checkUserRating($product_id)
    {
        return Rating::where('product_id', '=', $product_id)
            ->where('user_id', '=', auth()->user()->id)
            ->count();
    }
}
