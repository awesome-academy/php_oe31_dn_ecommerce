<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LoginRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin-redirect')->except('logout');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loginGet()
    {
        return view('admin.login');
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginPost(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        $user = User::where('email', '=', $request->email)->first();
        if ($user == null) {
            return redirect()->back()->with('status', trans('custome.fail_signin'));
        } else {
            if ($user->role_id != Role::SUPER_ADMIN && $user->role_id != Role::ADMIN) {
                abort(403, trans('custome.unauthorized_action'));
            } else if (Auth::attempt($credentials)) {
                return redirect()->route('admin.home.index');
            } else {
                return redirect()->back()->with('status', trans('custome.fail_signin'));
            }
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('admin.login.get');
    }
}
