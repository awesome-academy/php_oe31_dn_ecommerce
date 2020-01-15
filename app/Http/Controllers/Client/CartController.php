<?php

namespace App\Http\Controllers\Client;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
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
            $product = Product::findOrFail($id);
            $issetCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($issetCart);
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
            $product = Product::findOrFail($id);
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
