<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            // Roles & Users
            'create-roles', 'edit-roles', 'delete-roles', 'view-roles',
            'create-users', 'edit-users', 'delete-users', 'view-users',

            // Articles
            'write-articles', 'edit-articles', 'delete-articles',
            'publish-articles', 'unpublish-articles', 'view-articles',

            // Invoices & Payments
            'generate-invoices', 'view-invoices',
            'approve-payments', 'refund-payments',

            // Admin
            'access-admin-dashboard', 'manage-settings', 'view-logs', 'clear-cache',

            // Profiles
            'edit-profile', 'view-profile',

            // Appointments
            'create-appointments', 'edit-appointments',
            'cancel-appointments', 'view-appointments',

            // Reports
            'generate-reports', 'view-reports',
        ];
        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Define roles and their permissions
        $roles = [
            'admin' => [
                'create-roles', 'edit-roles', 'delete-roles', 'view-roles',
                'create-users', 'edit-users', 'delete-users', 'view-users',

                // Articles
                'write-articles', 'edit-articles', 'delete-articles',
                'publish-articles', 'unpublish-articles', 'view-articles',

                // Invoices & Payments
                'generate-invoices', 'view-invoices',
                'approve-payments', 'refund-payments',

                // Admin
                'access-admin-dashboard', 'manage-settings', 'view-logs', 'clear-cache',

                // Profiles
                'edit-profile', 'view-profile',

                // Appointments
                'create-appointments', 'edit-appointments',
                'cancel-appointments', 'view-appointments',

                // Reports
                'generate-reports', 'view-reports',
            ],
            'editor' => [
                  // Articles
                  'write-articles', 'edit-articles', 'delete-articles',
                  'publish-articles', 'unpublish-articles', 'view-articles',
                    // Profiles
                'edit-profile', 'view-profile',

            ],
            'user' => [
                // Profiles
                'edit-profile', 'view-profile',
            ], // no specific permissions
        ];

        // Create roles and assign permissions
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Only sync if rolePermissions is not empty
            if (!empty($rolePermissions)) {
                $role->syncPermissions($rolePermissions);
            }
        }
    }
}
