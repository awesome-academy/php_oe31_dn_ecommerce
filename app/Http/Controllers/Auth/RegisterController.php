<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Role;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->middleware('guest')->except('index', 'create');
        $this->userRepo = $userRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('client.register');
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(RegisterRequest $request)
    {
        $user = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'city_id' => $request->city,
            'role_id' => Role::USER,
            'status' => User::ACTIVE,
        ];
        if ($request->has('gender')) {
            $user['gender'] = $request->gender;
        }
        if ($request->has('gender')) {
            $user['birthdate'] = $request->birthdate;
        }
        $this->userRepo->create($user);

        return redirect()->route('client.login.get')
            ->with('registerSuccess', trans('custome.sign_up_success'));
    }
}
