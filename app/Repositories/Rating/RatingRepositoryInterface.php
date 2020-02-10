<?php

namespace App\Repositories\Rating;

interface RatingRepositoryInterface
{
    /**
     * Check order success
     * @return mixed
     * @param $product_id
     */
    public function checkOrderSuccess($product_id);

    /**
     * Check user rated
     * @param $product_id
     * @return mixed
     */
    public function checkUserRating($product_id);
}
