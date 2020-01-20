<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\RatingRequest;
use App\Models\Comment;
use App\Models\OrderDetail;
use App\Models\Rating;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Helpers\FilterHelper;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['comment', 'rating']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $numPagination = config('custome.paginate_pro');
        $products = Product::paginate($numPagination);

        return view('client.products.index', ['products' => $products]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function detail($id)
    {
        try {
            $product = Product::findOrFail($id);

            return view('client.products.detail', ['product' => $product]);
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param $filterBy
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filter($filterBy)
    {
        $products = Product::class;
        $numPagination = config('custome.paginate_pro');

        switch ($filterBy) {
            case config('custome.filter_by.price_ascending'):
                $products = FilterHelper::filter($products, 'price', 'ASC');
                break;
            case config('custome.filter_by.price_descending'):
                $products = FilterHelper::filter($products, 'price', 'DESC');
                break;
            case config('custome.filter_by.name_a_z'):
                $products = FilterHelper::filter($products, 'name', 'ASC');
                break;
            case config('custome.filter_by.name_z_a'):
                $products = FilterHelper::filter($products, 'name', 'DESC');
                break;
            case config('custome.filter_by.oldest'):
                $products = FilterHelper::filter($products, 'id', 'ASC');
                break;
            case config('custome.filter_by.newest'):
                $products = FilterHelper::filter($products, 'id', 'DESC');
                break;
            default:
                abort(404);
        }
        $products = $products->paginate($numPagination);

        return view('client.products.filter', ['products' => $products, 'filterBy' => $filterBy]);
    }

    /**
     * @param CommentRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function comment(CommentRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            Comment::create([
                'user_id' => auth()->user()->id,
                'product_id' => $id,
                'content' => $request->content,
                'status' => Comment::ACTIVE,
            ]);

            return redirect()->back();
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function rating(RatingRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $checkOrder = DB::table('order_details')
                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->where('orders.user_id', '=', auth()->user()->id)
                ->where('order_details.product_id', '=', $id)
                ->count();

            if ($checkOrder > config('custome.count_item')) {
                Rating::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $id,
                    'star_number' => $request->star_number,
                ]);

                return redirect()->back()->with('ratingSuccess', trans('custome.rating_success'));
            } else {
                return redirect()->back()->with('notRating', trans('custome.not_rating'));
            }
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
