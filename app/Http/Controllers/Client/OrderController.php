<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\OrderInforRequest;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;
use App\Repositories\OrderInfor\OrderInforRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Order;
use Pusher\Pusher;

class OrderController extends Controller
{
    protected $orderRepo;
    protected $orderInforRepo;
    protected $orderDetailRepo;
    protected $productRepo;

    public function __construct(OrderRepositoryInterface $orderRepo, OrderInforRepositoryInterface $orderInforRepo,
        OrderDetailRepositoryInterface $orderDetailRepo, ProductRepositoryInterface $productRepo
    ) {
        $this->middleware('guest');
        $this->orderRepo = $orderRepo;
        $this->orderInforRepo = $orderInforRepo;
        $this->orderDetailRepo = $orderDetailRepo;
        $this->productRepo = $productRepo;
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
     * @throws \Pusher\PusherException
     */
    public function create(OrderInforRequest $request)
    {
        if (!Session::has('cart')) {
            return view('client.orders.index');
        }
        $orderInfor = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'city_id' => $request->city,
        ];
        $orderInfor = $this->orderInforRepo->create($orderInfor);
        $cart = Session::get('cart');

        $order = [
            'user_id' => Auth::user()->id,
            'order_infor_id' => $orderInfor->id,
            'status' => Order::PENDING,
            'order_code' => Str::random(10),
            'total_price' => $cart->totalPrice,
        ];
        $order = $this->orderRepo->create($order);

        foreach ($cart->items as $item) {
            $product = $this->productRepo->findOrFail($item['item']->id);
            $data['quantity'] = $product->quantity -= $item['qty'];
            $this->productRepo->update($item['item']->id, $data);

            $orderDetail = [
                'order_id' => $order->id,
                'product_id' => $item['item']->id,
                'quantity' => $item['qty'],
            ];
            $this->orderDetailRepo->create($orderDetail);
        }
        Session::forget('cart');
        //order notify
        $orderNotify = [
            'id' => $order->id,
            'user' => $order->user->name,
            'created_at' => $order->created_at,
        ];
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            ['encrypted' => true]
        );
        $pusher->trigger('OrderNotify', 'send-message', $orderNotify);

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
