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

    /**
     * Get revenue by month or year
     * @param $month
     * @param $year
     * @return mixed
     */
    public function getByTime($month, $year);
}
