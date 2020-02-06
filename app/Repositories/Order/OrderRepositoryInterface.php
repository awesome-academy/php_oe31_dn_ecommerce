<?php

namespace App\Repositories\Order;

interface OrderRepositoryInterface
{
    /**
     * Get order by user id
     * @param $paginate
     * @return mixed
     */
    public function getOrderByUserId($paginate);
}
