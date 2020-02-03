<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\OrderInforRequest;
use App\Models\OrderInfor;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (!Session::has('cart')) {
            return view('client.orders.index');
        }
        $issetCart = Session::get('cart');
        $cart = new Cart($issetCart);

        return view('client.orders.index', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    /**
     * @param OrderInforRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(OrderInforRequest $request)
    {
        if (!Session::has('cart')) {
            return view('client.orders.index');
        }

        $orderInfor = new OrderInfor();
        $orderInfor->name = $request->name;
        $orderInfor->address = $request->address;
        $orderInfor->phone = $request->phone;
        $orderInfor->email = $request->email;
        $orderInfor->city_id = $request->city;
        $orderInfor->save();

        $cart = Session::get('cart');
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->order_infor_id = $orderInfor->id;
        $order->status = Order::PENDING;
        $order->order_code = Str::random(10);
        $order->total_price = $cart->totalPrice;
        $order->save();

        foreach ($cart->items as $item) {
            $product = Product::findOrFail($item['item']->id);
            $product->quantity -= $item['qty'];
            $product->save();

            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['item']->id,
                'quantity' => $item['qty'],
            ]);
        }
        Session::forget('cart');

        return view('client.orders.index', [
            'orderSuccess' => trans('custome.order_success'),
            'orderInfor' => $orderInfor,
            'orderCode' => $order->order_code,
            'products' => $cart->items,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function histories()
    {
        $numPaginate = config('custome.paginate_history_order');
        $orders = Order::where('user_id', '=', auth()->user()->id)->paginate($numPaginate);

        return view('client.orders.histories', ['orders' => $orders]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     */
    public function detail($id)
    {
        try {
            $order = Order::findOrFail($id);

            return view('client.orders.detail', ['order' => $order]);
        } catch (ModelNotFoundException $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function delete($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();

            return redirect()->back();
        } catch (ModelNotFoundException $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function increaseOne($id)
    {
        try {
            $orderDetail = OrderDetail::findOrFail($id);
            $product = Product::findOrFail($orderDetail->product->id);
            $order = Order::findOrFail($orderDetail->order->id);
            if ($order->status == Order::SUCCESS) {
                return redirect()->back()->with(['notEditOrder' => trans('custome.not_edit_order')]);
            }

            $quantityCurrent = $orderDetail->product->quantity;
            $quantityOrder = $orderDetail->quantity;
            $currentPrice = $order->total_price;

            if ($quantityCurrent <= $quantityOrder) {
                return redirect()->back()
                    ->with(['notAddProduct' => trans('custome.not_add_product', [
                            'quantity' => $orderDetail->product->quantity,
                            'name' => $orderDetail->product->name,
                        ])
                    ]);
            } else {
                $orderDetail->quantity++;
                $quantityOrder++;
                if ($orderDetail->product->sale_price != null) {
                    $order->total_price += $orderDetail->product->sale_price;
                } else {
                    $order->total_price += $orderDetail->product->price;
                }
                $orderDetail->save();
                $order->save();
                $product->quantity--;
                $product->save();

                return redirect()->back();
            }
        } catch (ModelNotFoundException $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function reduceOne($id)
    {
        try {
            $orderDetail = OrderDetail::findOrFail($id);
            $product = Product::findOrFail($orderDetail->product->id);
            $order = Order::findOrFail($orderDetail->order->id);

            if ($order->status == Order::SUCCESS) {
                return redirect()->back()->with(['notEditOrder' => trans('custome.not_edit_order')]);
            }
            $quantityOrder = $orderDetail->quantity;
            $orderDetail->quantity--;
            $newPrice = $order->total_price;

            if ($orderDetail->product->sale_price != null) {
                $newPrice -= $orderDetail->product->sale_price;
            } else {
                $newPrice -= $orderDetail->product->price;
            }

            if ($orderDetail->quantity == 0) {
                $orderDetail->delete();
            } else {
                $orderDetail->save();
            }

            if ($newPrice == config('custome.count_item')
                || count($order->order_details) <= config('custome.count_item')) {
                $order->delete();

                return redirect()->route('client.orders.histories');
            } else {
                $order->total_price = $newPrice;
                $order->save();
            }
            $product->quantity++;
            $product->save();

            return redirect()->back();
        } catch (ModelNotFoundException $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    public function removeItem($id)
    {
        try {
            $orderDetail = OrderDetail::findOrFail($id);
            $product = Product::findOrFail($orderDetail->product->id);
            $order = Order::findOrFail($orderDetail->order->id);

            if ($order->status == Order::SUCCESS) {
                return redirect()->back()->with(['notEditOrder' => trans('custome.not_edit_order')]);
            }

            if ($orderDetail->product->sale_price != null) {
                $order->total_price -= ($orderDetail->quantity * $orderDetail->product->sale_price);
            } else {
                $order->total_price -= ($orderDetail->quantity * $orderDetail->product->price);
            }
            $order->save();
            $orderDetail->delete();

            if ($order->total_price == 0) {
                $order->delete();

                return redirect()->route('client.orders.histories');
            } else {
                $order->save();

                return redirect()->back();
            }
        } catch (ModelNotFoundException $ex) {
            throw new Exception($ex->getMessage());
        }
    }
}
