<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        $roles = array(
        	[
        		'name' => 'super-admin',
        		'display_name' => 'Super Admin',
        		'description' => 'Super Admin have all roles '
        	],
        	[
        		'name' => 'admin',
        		'display_name' => 'System Administrator',
        		'description' => 'System Admin'
        	],
        	[
        		'name' => 'owner',
        		'display_name' => 'System User',
        		'description' => 'System user'
        	],
        	[
        		'name' => 'subscriber',
        		'display_name' => 'System operator',
        		'description' => 'System operator'
        	]


        );

        foreach ($roles as $role)
        {
            Role::create($role);
        }
        // Model::reguard();

    }
    
}
