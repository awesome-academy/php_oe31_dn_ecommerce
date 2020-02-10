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

    public function getByTime($month, $year)
    {
        $revenue = Order::orderBy('created_at', 'ASC')
            ->where('status', Order::SUCCESS)
            ->whereYear('created_at', $year);
        if ($month != null) {
            $revenue = Order::orderBy('created_at', 'ASC')
                ->where('status', Order::SUCCESS)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)->get();
        } else {
            $revenue = $revenue->get();
        }
        return $revenue;
    }


}
