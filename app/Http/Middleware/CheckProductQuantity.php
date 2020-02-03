<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Product;

class CheckProductQuantity
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        if ($request->id != null) {
            try {
                $product = Product::findOrFail($request->id);
                if ($product->quantity <= config('custome.count_item')) {
                    abort(403, trans('custome.not_add_pro_cart'));
                } else {
                    return $next($request);
                }
            } catch (ModelNotFoundException $ex) {
                throw new \Exception($ex->getMessage());
            }
        } else {
            abort(403);
        }
    }
}
