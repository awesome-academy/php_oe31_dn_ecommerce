<?php

namespace App\Repositories\Trend;

use App\Models\Trend;
use App\Repositories\BaseRepository;

class TrendRepository extends BaseRepository implements TrendRepositoryInterface
{
    public function getModel()
    {
        return Trend::class;
    }

    public function getFirstTrend()
    {
        return Trend::first();
    }
}
