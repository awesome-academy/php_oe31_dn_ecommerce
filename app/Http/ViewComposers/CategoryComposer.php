<?php

namespace App\Http\ViewComposers;
use App\Models\Category;
use Illuminate\View\View;

class CategoryComposer
{
    protected $categories;

    public function __construct()
    {
        $this->categories = Category::all();
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('categories', $this->categories);
    }
}
