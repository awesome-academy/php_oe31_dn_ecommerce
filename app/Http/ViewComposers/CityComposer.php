<?php

namespace App\Http\ViewComposers;
use App\Models\City;
use Illuminate\View\View;

class CityComposer
{
    protected $cities;

    public function __construct()
    {
        $this->cities = City::all();
    }

    public function compose(View $view)
    {
        $view->with('cities', $this->cities);
    }
}
