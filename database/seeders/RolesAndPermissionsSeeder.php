<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat permissions
        $permissions = [
            'view_post', 'create_post', 'edit_own_post', 'delete_own_post',
            'edit_any_post', 'delete_any_post', 'manage_users', 'manage_categories',
        ];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Role Super Admin
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Role Kontributor (5 tema: gizi, phbs, kb, lansia, jiwa)
        $contributor = Role::firstOrCreate(['name' => 'contributor']);
        $contributor->givePermissionTo([
            'view_post', 'create_post', 'edit_own_post', 'delete_own_post',
        ]);
    }
}