<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $paginate = config('custome.paginate_pro');
        $user = User::paginate($paginate);

        return view('admin.users.index', ['users' => $user]);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function lock($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = User::LOCK;
            $user->save();

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
    public function active($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = User::ACTIVE;
            $user->save();

            return redirect()->back();
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
