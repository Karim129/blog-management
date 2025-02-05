<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'create blog posts',
            'edit blog posts',
            'delete blog posts',
            'view all blog posts',
            'view own blog posts',
            'manage users',
            'import blog posts',
            'export all blog posts',
            'export own blog posts',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->syncPermissions([
            'create blog posts',
            'edit blog posts',
            'delete blog posts',
            'view all blog posts',
            'manage users',
            'import blog posts',
            'export all blog posts',
        ]);

        $author = Role::firstOrCreate(['name' => 'Author']);
        $author->syncPermissions([
            'create blog posts',
            'edit blog posts',
            'delete blog posts',
            'view own blog posts',
            'export own blog posts',
        ]);
    }
}
