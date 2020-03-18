<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Administrator',
            'slug' => 'administrator'
        ]);
        DB::table('roles')->insert([
            'name' => 'TopLevelManagemen',
            'slug' => 'toplevelmanagemen'
        ]);
        DB::table('roles')->insert([
            'name' => 'Operator',
            'slug' => 'operator'
        ]);
    }
}