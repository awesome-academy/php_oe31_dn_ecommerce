<?php

namespace App\Repositories\Suggest;

use App\Models\Suggest;
use App\Repositories\BaseRepository;

class SuggestRepository extends BaseRepository implements SuggestRepositoryInterface
{
    public function getModel()
    {
        return Suggest::class;
    }
}
