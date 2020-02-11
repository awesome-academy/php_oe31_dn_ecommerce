<?php

namespace App\Http\Controllers\Client;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    protected $categoryRepo;
    protected $productRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo, ProductRepositoryInterface $productRepo)
    {
        $this->categoryRepo = $categoryRepo;
        $this->productRepo = $productRepo;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function detail($id)
    {
        try {
            $category = $this->categoryRepo->findOrFail($id);
            $arr_id_child = [];
            $numPagination = config('custome.paginate_pro');
            $products = $this->productRepo->getByCategoryId($id, $category, $numPagination);

            return view('client.categories.detail', ['products' => $products, 'category' => $category]);
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param $id
     * @param $filterBy
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function filter($id, $filterBy)
    {
        try {
            $category = $this->categoryRepo->findOrFail($id);
            $numPagination = config('custome.paginate_pro');
            $products = $this->productRepo->filterByCategoryId($id, $category, $numPagination, $filterBy);

            return view('client.categories.filter', ['products' => $products, 'filterBy' => $filterBy]);
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
