<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $paginate = config('custome.paginate_pro');
        $order = Order::orderBy('created_at', 'DESC')->paginate($paginate);

        return view('admin.orders.index', ['orders' => $order]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function show($id)
    {
        try {
            $order = Order::findOrFail($id);

            return view('admin.orders.detail', ['order' => $order]);
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();

            return redirect()->back();
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function changeSuccess($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->status = Order::SUCCESS;
            $order->save();

            return redirect()->back();
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function changePending($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->status = Order::PENDING;
            $order->save();

            return redirect()->back();
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function changeCancel($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->status = Order::CANCEL;
            $order->save();

            return redirect()->back();
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
