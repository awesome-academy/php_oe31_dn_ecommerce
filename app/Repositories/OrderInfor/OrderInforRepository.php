<?php

namespace App\Repositories\OrderInfor;

use App\Models\OrderInfor;
use App\Repositories\BaseRepository;

class OrderInforRepository extends BaseRepository implements OrderInforRepositoryInterface
{
    public function getModel()
    {
        return OrderInfor::class;
    }
}
