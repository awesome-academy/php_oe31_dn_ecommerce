<?php

namespace App\Repositories\Image;

interface ImageRepositoryInterface
{
    /**
     * Get first image by product id
     * @param $id
     * @return mixed
     */
    public function getFirstImageByProductId($id);
}
