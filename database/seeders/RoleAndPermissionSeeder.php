<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'create-roles',
            'delete-users',
            'write-articles',
            'admin-dashboard'

        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        $roles = [
            'admin' => [
                'create-roles',
                'delete-users',
                'write-articles',
                'admin-dashboard'
            ],
            'user' => [

            ],
            'editor' => [
                'write-articles'
            ]



        ];
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
}
