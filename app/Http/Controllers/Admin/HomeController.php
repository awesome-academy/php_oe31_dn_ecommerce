<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.home.index');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function statistic()
    {
        $arr_data = [];
        $take = config('custome.take_seven');
        $orders = $this->orderRepo->getOrderLatest('created_at', 'DESC', $take);
        $arr_data['data_price'] = $orders->pluck('total_price');
        $arr_data['data_created_at'] = $orders->pluck('created_at');
        $arr_data['title'] = trans('custome.title_order_related');

        return response()->json($arr_data);
    }
}
