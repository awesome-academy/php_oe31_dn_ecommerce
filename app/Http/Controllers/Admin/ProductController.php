<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProductController extends Controller
{
    /**
     *
     */
    public function index()
    {
        $paginate = config('custome.paginate_pro');
        $products = Product::orderBy('id', 'DESC')->paginate($paginate);

        return view('admin.products.index', ['products' => $products]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(ProductRequest $request)
    {
        try {
            $storaPath = storage_path(config('custome.storage_path_product'));
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'category_id' => $request->category,
            ];
            request()->image->move($storaPath, $imageName);
            if ($request->has('sale_price')) {
                $data['sale_price'] = $request->sale_price;
            }
            if ($request->has('sale_percent')) {
                $data['sale_percent'] = $request->sale_percent;
            }
            $product = Product::create($data);
            $product->images()->create([
                'name' => $imageName,
                'type' => Image::FIRST,
            ]);

            return redirect()->back()->with('createSuccess', trans('custome.create_success'));
        } catch (FileException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);

            return view('admin.products.detail', ['product' => $product]);
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            if ($request->has('sale_price')) {
                $product->sale_price = $request->sale_price;
            }
            if ($request->has('sale_percent')) {
                $product->sale_percent = $request->sale_percent;
            }
            if ($request->hasFile('image')) {
                $storaPath = storage_path(config('custome.storage_path_product'));
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $image = Image::where('product_id', '=', $id)->where('type', '=', Image::FIRST)->first();
                $image->name = $imageName;
                request()->image->move($storaPath, $imageName);
                $image->save();
            }
            $product->save();

            return redirect()->back()->with('updateSuccess', trans('custome.update_success'));
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->back();
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
