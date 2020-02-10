<?php

namespace App\Http\Controllers\Client;

use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Trend\TrendRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $productRepo;
    protected $trendRepo;

    public function __construct(ProductRepositoryInterface $productRepo, TrendRepositoryInterface $trendRepo)
    {
        $this->productRepo = $productRepo;
        $this->trendRepo = $trendRepo;
    }

    public function index()
    {
        $firstTrend = $this->trendRepo->getFirstTrend();
        $numRelatedPro = config('custome.number_pro_related');
        $productRelateds = $this->productRepo->getRelatedProduct('id', 'DESC', $numRelatedPro);

        return view('client.home.index', ['trend' => $firstTrend, 'productRelateds' => $productRelateds]);
    }
}
