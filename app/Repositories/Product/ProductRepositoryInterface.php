<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    /**
     * Get products by category id
     * @param $id
     * @param $category
     * @param $paginate
     * @return mixed
     */
    public function getByCategoryId($id, $category, $paginate);

    /**
     * Filter product with category id
     * @param $id
     * @param $filterBy
     * @param $category
     * @param $paginate
     * @return mixed
     */
    public function filterByCategoryId($id, $filterBy, $category, $paginate);

    /**
     * Filter product
     * @param $filterBy
     * @param $paginate
     * @return mixed
     */
    public function filter($filterBy, $paginate);

    /**
     * Get related products
     * @param $column
     * @param $orderBy
     * @param $takeNum
     * @return mixed
     */
    public function getRelatedProduct($column, $orderBy, $takeNum);
}
