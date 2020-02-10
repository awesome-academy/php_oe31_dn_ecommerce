<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $paginate = config('custome.paginate_pro');
        $user = $this->userRepo->paginate(null, null, $paginate);

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
            $user['status'] = User::LOCK;
            if ($this->userRepo->update($id, $user)) {
                return redirect()->back();
            }
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
            $user['status'] = User::ACTIVE;
            if ($this->userRepo->update($id, $user)) {
                return redirect()->back();
            }
        } catch (ModelNotFoundException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
