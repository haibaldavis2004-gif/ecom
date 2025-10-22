<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Roles
        $admin = Role::updateOrCreate(['name' => 'admin'], ['name' => 'admin']);
        $manager = Role::updateOrCreate(['name' => 'manager'], ['name' => 'manager']);
        $customer = Role::updateOrCreate(['name' => 'customer'], ['name' => 'customer']);

        // Permissions
        $permissions = [
            'create_products','update_products','delete_products','view_products',
            'create_purchases','update_purchases','delete_purchases','view_purchases',
            'create_users','update_users','delete_users','view_users',
            'create_categories','update_categories','delete_categories','view_categories',
            'create_subcategories','update_subcategories','delete_subcategories','view_subcategories',
            'create_purchase_items','update_purchase_items','delete_purchase_items','view_purchase_items',
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(['name' => $perm], ['name' => $perm]);
        }

        // Assign permissions to roles
        // Admin → all permissions
        $admin->permissions()->sync(Permission::all()->pluck('id'));

        // Manager → all except delete permissions
        // Manager → all except delete_*
       $managerPermissions = Permission::whereIn('name', [
         'create_users', // ← add this
    'update_users', // if needed
    'view_users',   // if needed
    'create_products', 'update_products', 'view_products',
    'create_purchases', 'update_purchases', 'view_purchases',
    'create_categories', 'update_categories', 'view_categories',
    'create_subcategories', 'update_subcategories', 'view_subcategories',
    'create_purchase_items', 'update_purchase_items', 'view_purchase_items'
])->pluck('id');

$manager->permissions()->sync($managerPermissions);



        // Customer → view only + create_purchases
       // Gets exactly 9 permissions (browse + own orders only)
$customerPermissions = Permission::whereIn('name', [
    'view_users', // ← add this
     // if needed
    'view_products', 'view_categories', 'view_subcategories',
    'create_purchases', 'view_purchases', 'update_purchases',
    'create_purchase_items', 'view_purchase_items', 'update_purchase_items'
])->pluck('id');
$customer->permissions()->sync($customerPermissions);

        // ✅ Assign roles to users by email instead of ID
        User::where('email', 'admin@example.com')->update(['role_id' => $admin->id]);
        User::where('email', 'manager@example.com')->update(['role_id' => $manager->id]);
        User::where('email', 'customer@example.com')->update(['role_id' => $customer->id]);
    }
}
