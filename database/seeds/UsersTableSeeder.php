<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'Administrator',
            'username' => 'administrator',
            'email' => 'admin@gmail.com',
            'no_telphone' => '082145888899',
            'address' => 'Denpasar',
            'password' => bcrypt('admin123'),
            'status' => 'ACTIVE',
        ]);
        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'TopLevelManagemen',
            'username' => 'toplevelmanagemen',
            'email' => 'toplevelm@gmail.com',
            'no_telphone' => '0821458777444',
            'address' => 'Denpasar',
            'password' => bcrypt('admin123'),
            'status' => 'ACTIVE',

        ]);
        DB::table('users')->insert([
            'role_id' => '3',
            'name' => 'Operator',
            'username' => 'operator',
            'email' => 'operator@gmail.com',
            'no_telphone' => '0821456695225',
            'address' => 'Tabanan',
            'password' => bcrypt('admin123'),
            'status' => 'ACTIVE',

        ]);
    }
}
