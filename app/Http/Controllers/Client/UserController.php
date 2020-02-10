<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile()
    {
        $user = $this->userRepo->getCurrentUser();

        return view('client.users.profile', ['user' => $user]);
    }

    /**
     * @param UserUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(UserUpdateRequest $request)
    {
        try {
            $user = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'city_id' => $request->city,
            ];
            if ($request->has('gender')) {
                $user['gender'] = $request->gender;
            }
            if ($request->has('birthdate')) {
                $user['birthdate'] = $request->birthdate;
            }
            if ($this->userRepo->update(auth()->user()->id, $user)) {
                return redirect()->back()->with(['updateSuccess' => trans('custome.update_success')]);
            }
        } catch (ModelNotFoundException $ex) {
            throw new Exception($ex->getMessage());
        }
    }
}
