<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use App\Models\Trend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function index()
    {
        $firstTrend = Trend::first();
        $numRelatedPro = config('custome.number_pro_related');
        $productRelateds = Product::orderBy('id', 'DESC')->take($numRelatedPro)->get();

        return view('client.home.index', ['trend' => $firstTrend, 'productRelateds' => $productRelateds]);
    }
}
