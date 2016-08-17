<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Permission;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('permission_role')->delete();
       DB::table('role_user')->delete();
        $permissions = Permission::all();
        $permission1 = Permission::where('name','=','role-list');
        $superadminRole = Role::where('name','=','super-admin')->get()->first() ;
        $adminRole = Role::where('name','=','admin')->get()->first() ;
        $superUser = User::where('name', '=', 'superadmin')->get()->first() ;
        $adminUser = User::where('name', '=', 'admin')->get()->first();

		foreach ($permissions as $permission)
        {
            $superadminRole->permissions()->attach($permission->id);
            $adminRole->permissions()->attach($permission->id);
        }
		
        $superUser->roles()->attach($superadminRole->id); // id only

        $adminUser->roles()->attach($adminRole->id); // id only
    }
    
}
