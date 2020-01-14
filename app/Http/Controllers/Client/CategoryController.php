<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function detail($id)
    {
        try {
            $category = Category::findOrFail($id);
            $arr_id_child = [];
            $numPagination = config('custome.paginate_pro');

            if (sizeof($category->children) > config('custome.count_category')) {
                foreach ($category->children as $child) {
                    array_push($arr_id_child, $child->id);
                }
                $products = Product::whereIn('category_id', $arr_id_child)->paginate($numPagination);
            } else {
                $products = $category->products()->paginate($numPagination);
            }

            return view('client.categories.detail',['products' => $products, 'category' => $category]);
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
            $category = Category::findOrFail($id);
            $arr_id_child = [];
            $numPagination = config('custome.paginate_pro');
            $products = Product::class;

            if (sizeof($category->children) > config('custome.count_category')) {
                foreach ($category->children as $child) {
                    array_push($arr_id_child, $child->id);
                }
                $products = Product::whereIn('category_id', $arr_id_child);

            } else {
                $products = Product::where('category_id', '=', $id);
            }

            switch ($filterBy) {
                case config('custome.filter_by.price_ascending'):
                    $products = $products->orderBy('price', 'ASC');
                    break;
                case config('custome.filter_by.price_descending'):
                    $products = $products->orderBy('price', 'DESC');
                    break;
                case config('custome.filter_by.name_a_z'):
                    $products = $products->orderBy('name', 'ASC');
                    break;
                case config('custome.filter_by.name_z_a'):
                    $products = $products->orderBy('name', 'DESC');
                    break;
                case config('custome.filter_by.oldest'):
                    $products = $products->orderBy('id', 'ASC');
                    break;
                case config('custome.filter_by.newest'):
                    $products = $products->orderBy('id', 'DESC');
                    break;
                default:
                    abort(404);
            }
            $products = $products->paginate($numPagination);

            return view('client.categories.filter', ['products' => $products, 'filterBy' => $filterBy]);
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
