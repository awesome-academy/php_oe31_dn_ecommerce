<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\OrderInforRequest;
use App\Models\OrderInfor;
use App\Repositories\Order\OrderRepositoryInterface;
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
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->middleware('guest');
        $this->orderRepo = $orderRepo;
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
        $orders = $this->orderRepo->getOrderByUserId($numPaginate);

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
            $order = $this->orderRepo->findOrFail($id);

            return view('client.orders.detail', ['order' => $order]);
        } catch (ModelNotFoundException $ex) {
            throw new Exception($ex->getMessage());
        }
    }
}
