<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for ecommerce+pos system
        $permissions = [
            // Dashboard permissions
            'view dashboard',
            'view analytics',
            
            // User management
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Customer management  
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',
            
            // Product management
            'view products',
            'create products',
            'edit products',
            'delete products',
            'manage inventory',
            'view inventory reports',
            
            // Category management
            'view categories',
            'create categories',
            'edit categories', 
            'delete categories',
            
            // Brand management
            'view brands',
            'create brands',
            'edit brands',
            'delete brands',
            
            // Order management
            'view orders',
            'create orders',
            'edit orders',
            'cancel orders',
            'refund orders',
            'fulfill orders',
            'view order reports',
            
            // POS operations
            'access pos',
            'process sales',
            'handle returns',
            'apply discounts',
            'void transactions',
            'view pos reports',
            'manage pos terminals',
            
            // Payment management
            'view payments',
            'process payments',
            'refund payments',
            'view payment reports',
            
            // Coupon management
            'view coupons',
            'create coupons',
            'edit coupons',
            'delete coupons',
            
            // Supplier management
            'view suppliers',
            'create suppliers',
            'edit suppliers',
            'delete suppliers',
            
            // Reports and analytics
            'view sales reports',
            'view financial reports',
            'view customer reports',
            'view inventory reports',
            'export reports',
            
            // Settings
            'manage settings',
            'manage roles',
            'manage permissions',
            'manage tax settings',
            'manage shipping settings',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Super Admin - Full access
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->syncPermissions(Permission::all());
        
        // Admin - Most permissions except system critical
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $adminPermissions = Permission::whereNotIn('name', [
            'manage roles',
            'manage permissions',
        ])->get();
        $admin->syncPermissions($adminPermissions);
        
        // Manager - Store management
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $managerPermissions = [
            'view dashboard',
            'view analytics',
            'view users',
            'view customers', 'create customers', 'edit customers',
            'view products', 'create products', 'edit products',
            'manage inventory', 'view inventory reports',
            'view categories', 'create categories', 'edit categories',
            'view brands', 'create brands', 'edit brands',
            'view orders', 'create orders', 'edit orders', 'cancel orders', 'fulfill orders',
            'access pos', 'process sales', 'handle returns', 'apply discounts',
            'view payments', 'process payments',
            'view coupons', 'create coupons', 'edit coupons',
            'view suppliers', 'create suppliers', 'edit suppliers',
            'view sales reports', 'view financial reports', 'view customer reports',
            'export reports',
        ];
        $manager->syncPermissions($managerPermissions);
        
        // Cashier - POS focused
        $cashier = Role::firstOrCreate(['name' => 'cashier']);
        $cashierPermissions = [
            'view dashboard',
            'view customers', 'create customers', 'edit customers',
            'view products',
            'view orders', 'create orders',
            'access pos', 'process sales', 'handle returns', 'apply discounts',
            'view payments', 'process payments',
            'view coupons',
        ];
        $cashier->syncPermissions($cashierPermissions);
        
        // Sales Representative
        $salesRep = Role::firstOrCreate(['name' => 'sales-representative']);
        $salesRepPermissions = [
            'view dashboard',
            'view customers', 'create customers', 'edit customers',
            'view products',
            'view orders', 'create orders', 'edit orders',
            'view payments',
            'view coupons',
        ];
        $salesRep->syncPermissions($salesRepPermissions);
        
        // Inventory Manager
        $inventoryManager = Role::firstOrCreate(['name' => 'inventory-manager']);
        $inventoryPermissions = [
            'view dashboard',
            'view products', 'create products', 'edit products',
            'manage inventory', 'view inventory reports',
            'view categories', 'create categories', 'edit categories',
            'view brands', 'create brands', 'edit brands',
            'view suppliers', 'create suppliers', 'edit suppliers',
            'view orders', 'fulfill orders',
            'export reports',
        ];
        $inventoryManager->syncPermissions($inventoryPermissions);
        
        // Customer Support
        $support = Role::firstOrCreate(['name' => 'customer-support']);
        $supportPermissions = [
            'view dashboard',
            'view customers', 'edit customers',
            'view products',
            'view orders', 'edit orders', 'refund orders',
            'view payments', 'refund payments',
            'handle returns',
        ];
        $support->syncPermissions($supportPermissions);
        
        // Customer - Limited access
        $customer = Role::firstOrCreate(['name' => 'customer']);
        $customerPermissions = [
            'view products',
            'view orders',
            'create orders',
        ];
        $customer->syncPermissions($customerPermissions);

        // Create default super admin user
        $user = User::firstOrCreate([
            'email' => 'janonemersion@hotmail.com',
        ], [
            'name' => 'Janon Emersion T',
            'password' => Hash::make('Jj112112@!@!'),
            'email_verified_at' => now(),
        ]);
        
        if (!$user->hasRole('Janon Emersion T')) {
            $user->assignRole('super-admin');
        }

        $this->command->info('Roles and permissions created successfully!');
        $this->command->info('Default admin user created - Email: admin@example.com, Password: password');
    }
}
