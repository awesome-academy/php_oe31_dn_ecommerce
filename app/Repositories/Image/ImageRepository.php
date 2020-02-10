<?php

namespace App\Repositories\Image;

use App\Models\Image;
use App\Repositories\BaseRepository;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{
    public function getModel()
    {
        return Image::class;
    }

    public function getFirstImageByProductId($id)
    {
        return Image::where('product_id', '=', $id)
            ->where('type', '=', Image::FIRST)->first();
    }
}
