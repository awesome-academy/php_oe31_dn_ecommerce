<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getCurrentUser();

    /**
     * @param $email
     * @return mixed
     */
    public function getUserByEmail($email);
}
