<?php

use Illuminate\Database\Seeder;
Use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->delete();

        $users = array(
            ['name' => 'superadmin', 'email' => 'superadmin@admin.co', 'password' => Hash::make('secret')],
            ['name' => 'admin', 'email' => 'admin@admin.co', 'password' => Hash::make('secret')],
            ['name' => 'owner', 'email' => 'owner@admin.co', 'password' => Hash::make('secret')],
            ['name' => 'subscriber', 'email' => 'subscriber@admin.co', 'password' => Hash::make('secret')],
        );

        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}
