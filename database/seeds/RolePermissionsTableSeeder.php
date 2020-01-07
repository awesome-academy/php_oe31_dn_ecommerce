<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seeding permissons
         */
        $permissions = [
            'Create', 'Read', 'Update', 'Delete'
        ];
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }

        /**
         * Seeding roles
         */
        $roles = [
            'Super Admin', 'Admin', 'User',
        ];
        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
            ]);
        }

        /**
         *  Seeding role-permissions
         */
        foreach ($roles as $role) {
            switch ($role) {
                case 'Super Admin':
                    //Full
                    for($i = 1; $i <= 4; $i++) {
                        RolePermission::create([
                            'role_id' => 1,
                            'permission_id' => $i,
                        ]);
                    }
                    break;
                case 'Admin':
                    //expect Delete
                    for($i = 1; $i <= 3; $i++) {
                        RolePermission::create([
                            'role_id' => 2,
                            'permission_id' => $i,
                        ]);
                    }
                    break;
                case 'User':
                    //Full
                    for($i = 1; $i <= 4; $i++) {
                        RolePermission::create([
                            'role_id' => 3,
                            'permission_id' => $i,
                        ]);
                    }
                    break;
            }
        }
    }
}
