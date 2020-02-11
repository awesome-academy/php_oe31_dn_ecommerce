<?php

namespace App\Http\Controllers\Client;

use App\Repositories\Product\ProductRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->middleware(['guest', 'check-product-qty'])->except(['index', 'removeItem']);
        $this->productRepo = $productRepo;
    }

    public function index()
    {
        if (!Session::has('cart')) {
            return view('client.carts.index');
        }
        $issetCart = Session::get('cart');
        $cart = new Cart($issetCart);

        return view('client.carts.index',
            ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function addToCart(Request $request, $id)
    {
        try {
            $product = $this->productRepo->findOrFail($id);
            $issetCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($issetCart);
            if ($cart->items != null && array_key_exists($id, $cart->items)) {
                return redirect()->back()
                    ->with('statusProductExist', trans('custome.cart_product_exists'));
            }
            $cart->add($product, $product->id);
            $request->session()->put('cart', $cart);

            return redirect()->back();
        } catch (ModelNotFoundException $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    public function increaseOne($id)
    {
        try {
            $product = $this->productRepo->findOrFail($id);
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            if ($product->quantity <= $cart->items[$id]['qty']) {
                return redirect()->back()
                    ->with(['notAddProduct'
                        => trans('custome.not_add_product',[
                                'quantity' => $product->quantity,
                                'name' => $product->name,
                            ])
                        ]);
            } else {
                $cart->increaseOne($id);
            }
            Session::put('cart', $cart);

            return redirect()->back();
        } catch (ModelNotFoundException $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reduceByOne($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceOne($id);

        if (count($cart->items) > config('custome.count_item')) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }

        return redirect()->back();
    }

    public function removeItem($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);

        if (count($cart->items) > config('custome.count_item')) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }

        return redirect()->back();
    }
}
