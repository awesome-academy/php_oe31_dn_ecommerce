<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seeding Super Admin
         */
        User::create([
           'name' => 'Super Admin',
            'phone' => '0987999999',
            'email' => 'superadmin@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'address' => '!6 Lý Thường Kiệt',
            'city_id' => 1,
            'role_id' => 1,
        ]);

        /**
         * Seeding Admin
         */
        User::create([
            'name' => 'Admin',
            'phone' => '0987888888',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'address' => '127 Tống Duy Tân',
            'city_id' => 1,
            'role_id' => 2,
        ]);

        /**
         * Seeding User
         */
        factory(User::class, 100)->create();
    }
}
