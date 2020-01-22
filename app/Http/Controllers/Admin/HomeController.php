<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
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
        $orders = Order::orderBy('created_at', 'DESC')->take(config('custome.take_order_statistic'));
        $arr_data['data_price'] = $orders->pluck('total_price');
        $arr_data['data_created_at'] = $orders->pluck('created_at');
        $arr_data['title'] = trans('custome.title_order_related');

        return response()->json($arr_data);
    }
}
