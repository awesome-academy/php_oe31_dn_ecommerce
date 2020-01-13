<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Helpers\FilterHelper;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $numPagination = config('custome.paginate_pro');
        $products = Product::paginate($numPagination);

        return view('client.products.index', ['products' => $products]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function detail($id)
    {
        try {
            $product = Product::findOrFail($id);

            return view('client.products.detail', ['product' => $product]);
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param $filterBy
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filter($filterBy)
    {
        $products = Product::class;
        $numPagination = config('custome.paginate_pro');

        switch ($filterBy) {
            case config('custome.filter_by.price_ascending'):
                $products = FilterHelper::filter($products, 'price', 'ASC');
                break;
            case config('custome.filter_by.price_descending'):
                $products = FilterHelper::filter($products, 'price', 'DESC');
                break;
            case config('custome.filter_by.name_a_z'):
                $products = FilterHelper::filter($products, 'name', 'ASC');
                break;
            case config('custome.filter_by.name_z_a'):
                $products = FilterHelper::filter($products, 'name', 'DESC');
                break;
            case config('custome.filter_by.oldest'):
                $products = FilterHelper::filter($products, 'id', 'ASC');
                break;
            case config('custome.filter_by.newest'):
                $products = FilterHelper::filter($products, 'id', 'DESC');
                break;
            default:
                abort(404);
        }
        $products = $products->paginate($numPagination);

        return view('client.products.filter', ['products' => $products, 'filterBy' => $filterBy]);
    }
}
