<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\RatingRequest;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Rating\RatingRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\FilterHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;

class ProductController extends Controller
{
    protected $commentRepo;
    protected $productRepo;
    protected $ratingRepo;

    public function __construct(CommentRepository $commentRepo, ProductRepositoryInterface $productRepo,
        RatingRepositoryInterface $ratingRepo
    )
    {
        $this->middleware('auth')->only(['comment', 'rating', 'getEditComment', 'postEditComment']);
        $this->middleware('check-user-comment')->only(['getEditComment', 'postEditComment']);

        $this->commentRepo = $commentRepo;
        $this->productRepo = $productRepo;
        $this->ratingRepo = $ratingRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $numPagination = config('custome.paginate_pro');
        $products = $this->productRepo->paginate('id', 'DESC', $numPagination);

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
            $product = $this->productRepo->findOrFail($id);

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
        $numPagination = config('custome.paginate_pro');
        $products = $this->productRepo->filter($filterBy, $numPagination);

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
            $product = $this->productRepo->findOrFail($id);
            $this->commentRepo->create([
                'user_id' => Auth::user()->id,
                'product_id' => $id,
                'content' => $request->content,
                'status' => Comment::ACTIVE,
            ]);

            return redirect()->back();
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function getEditComment($id)
    {
        try {
            $comment = $this->commentRepo->findOrFail($id);

            return view('client.products.comments.edit', ['comment' => $comment]);
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function postEditComment(CommentRequest $request)
    {
        try {
            $comment = $this->commentRepo->findOrFail($request->id);
            $attributes['content'] = $request->content;

            $this->commentRepo->update($request->id, $attributes);

            return redirect(route('client.products.detail', ['id' => $comment->product->id]));
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function rating(RatingRequest $request, $id)
    {
        try {
            $checkOrder = $this->ratingRepo->checkOrderSuccess($id);
            $checkRating = $this->ratingRepo->checkUserRating($id);

            if ($checkRating >= config('custome.count_item_1')) {
                return redirect()->back()->with('statusRated', trans('custome.status_rated_product'));
            } else if ($checkOrder == config('custome.count_item_1') && $checkRating < config('custome.count_item_1')) {
                $this->ratingRepo->create([
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
