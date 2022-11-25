<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'project-list',
            'project-create',
            'project-edit',
            'project-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'investor-list',
            'investor-create',
            'investor-settings',
            'position-list',
            'position-create',
            'position-edit',
            'position-edit-all'
        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }

        $user = User::find(4);

        $role = Role::find(3);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
