<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }

    public function getOrderByUserId($paginate)
    {
        return Order::where('user_id', '=', auth()->user()->id)
            ->orderBy('id', 'DESC')->paginate($paginate);
    }
}
