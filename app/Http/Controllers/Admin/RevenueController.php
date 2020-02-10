<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Repositories\Order\OrderRepositoryInterface;

class RevenueController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function index()
    {
        $orders = $this->orderRepo->orderBy('created_at', 'DESC');
        $years = [];
        foreach ($orders as $item) {
            $year = Carbon::parse($item->created_at)->year;
            if (!in_array($year, $years)) {
                array_push($years, $year);
            }
        }
        return view('admin.revenue.index', ['years' => $years]);
    }

    public function getCurrentMonth()
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $revenue = $this->orderRepo->getByTime($month, $year);
        $arr_data['title'] = trans('custome.get_revenue_current_month');
        $this->filterArrayRevenue($arr_data, $revenue, 'd-m');

        return response()->json($arr_data);
    }

    public function filterRevenue()
    {
        $year = Input::get('year');
        $month = Input::get('month');
        $revenue = $this->orderRepo->getByTime($month, $year);

        if (!is_null($month)) {
            $this->filterArrayRevenue($arr_data, $revenue, 'd-m-Y');
            $arr_data['title'] = trans('custome.revenue_get', ['time' => $month . "-" . $year]);
        } else {
            $this->filterArrayRevenue($arr_data, $revenue, 'm-Y');
            $arr_data['title'] = trans('custome.revenue_get', ['time' => $year]);
        }

        return response()->json($arr_data);
    }

    public function filterArrayRevenue(&$arr_data, $revenue, $format)
    {
        $arr_data['item'] = [];
        $arr_data['money'] = [];
        foreach($revenue as $item) {
            $itemFormat = Carbon::parse($item->created_at)->format($format);
            if (!in_array($itemFormat, $arr_data['item'])) {
                array_push($arr_data['item'], $itemFormat);
                array_push($arr_data['money'], $item->total_price);
            } else {
                if (sizeof($arr_data['money']) > config('custome.count_item')) {
                    $arr_data['money'][sizeof($arr_data['money']) - config('custome.count_item_1')] += $item->total_price;
                }
            }
        }
    }
}
