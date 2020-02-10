<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getCurrentUser()
    {
        return Auth::user();
    }

    public function getUserByEmail($email)
    {
        return User::where('email', '=', $email)->first();
    }
}
