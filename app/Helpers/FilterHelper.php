<?php

namespace App\Helpers;

class FilterHelper
{
    public static function filter($model, $colum, $orderBy)
    {
        return $model::orderBy($colum, $orderBy);
    }
}
