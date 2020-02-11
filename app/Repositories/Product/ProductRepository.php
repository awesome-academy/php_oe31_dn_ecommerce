<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }

    public function getByCategoryId($id, $category, $paginate)
    {
        $arr_id_child = [];
        if (sizeof($category->children) > config('custome.count_category')) {
            foreach ($category->children as $child) {
                array_push($arr_id_child, $child->id);
            }
            return Product::whereIn('category_id', $arr_id_child)->paginate($paginate);
        } else {
            return Product::where('category_id', '=', $id)->paginate($paginate);
        }
    }

    public function filter($filterBy, $paginate)
    {
        switch ($filterBy) {
            case config('custome.filter_by.price_ascending'):
                $products = $this->model->orderBy('price', 'ASC');
                break;
            case config('custome.filter_by.price_descending'):
                $products =  $this->model->orderBy('price', 'DESC');
                break;
            case config('custome.filter_by.name_a_z'):
                $products =  $this->model->orderBy('name', 'ASC');
                break;
            case config('custome.filter_by.name_z_a'):
                $products =  $this->model->orderBy('name', 'DESC');
                break;
            case config('custome.filter_by.oldest'):
                $products =  $this->model->orderBy('id', 'ASC');
                break;
            case config('custome.filter_by.newest'):
                $products =  $this->model->orderBy('id', 'DESC');
                break;
            default:
                abort(404);
        }
        return $products->paginate($paginate);
    }

    public function filterByCategoryId($id, $category, $paginate, $filterBy)
    {
        $arr_id_child = [];
        $products = $this->model;
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
        return $products = $products->paginate($paginate);
    }

    public function getRelatedProduct($column, $orderBy, $takeNum)
    {
        return $this->model->orderBy($column, $orderBy)->take($takeNum)->get();
    }
}
