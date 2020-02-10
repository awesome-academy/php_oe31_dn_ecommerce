<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProductController extends Controller
{
    protected $productRepo;
    protected $imageRepo;

    public function __construct(ProductRepositoryInterface $productRepo, ImageRepositoryInterface $imageRepo)
    {
        $this->productRepo = $productRepo;
        $this->imageRepo = $imageRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $paginate = config('custome.paginate_pro');
        $products = $this->productRepo->paginate('id', 'DESC', $paginate);

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
            $storaPath = storage_path(config('custome.path_storage_product'));
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
            $product = $this->productRepo->create($data);
            $this->imageRepo->create([
                'name' => $imageName,
                'type' => Image::FIRST,
                'product_id' => $product->id,
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
            $product = $this->productRepo->findOrFail($id);

            return view('admin.products.detail', ['product' => $product]);
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        try {
            $product = [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ];
            if ($request->has('sale_price')) {
                $product['sale_price'] = $request->sale_price;
            }
            if ($request->has('sale_percent')) {
                $product['sale_percent'] = $request->sale_percent;
            }
            if ($request->hasFile('image')) {
                $storaPath = storage_path(config('custome.path_storage_product'));
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $image = $this->imageRepo->getFirstImageByProductId($id);
                $imageUpdate = ['name' => $imageName];

                $this->imageRepo->update($image->id, $imageUpdate);
                request()->image->move($storaPath, $imageName);
            }
            $this->productRepo->update($id, $product);

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
            if ($this->productRepo->delete($id)) {
                return redirect()->back();
            }
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
