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

    /**
     * Get orders that is not handled
     * @return mixed
     */
    public function getOrderNotHandleWeek();
}
