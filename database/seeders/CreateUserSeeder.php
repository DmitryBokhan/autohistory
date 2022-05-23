<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateUserSeeder extends Seeder
{
    /**
     * Запустить начальные данные базы данных.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'User1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $role = Role::create(['name' => 'User']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
