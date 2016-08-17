<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermisionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();
       $permission = [
            [
                'name' => 'role-list',
                'display_name' => 'Display Role Listing',
                'description' => 'See only Listing Of Role'
            ],
            [
                'name' => 'role-create',
                'display_name' => 'Create Role',
                'description' => 'Create New Role'
            ],
            [
                'name' => 'role-edit',
                'display_name' => 'Edit Role',
                'description' => 'Edit Role'
            ],
            [
                'name' => 'role-delete',
                'display_name' => 'Delete Role',
                'description' => 'Delete Role'
            ],
            [
                'name' => 'user-list',
                'display_name' => 'Display Item Listing',
                'description' => 'See only Listing Of Item'
            ],
            [
                'name' => 'user-create',
                'display_name' => 'Create Item',
                'description' => 'Create New Item'
            ],
            [
                'name' => 'user-edit',
                'display_name' => 'Edit Item',
                'description' => 'Edit Item'
            ],
            [
                'name' => 'user-delete',
                'display_name' => 'Delete Item',
                'description' => 'Delete Item'
            ]
        ];
        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
