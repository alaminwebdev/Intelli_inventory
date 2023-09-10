<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Admin',
            'description' => 'Admin',
            'status' => 1,
            'deleted_at' => NULL,
            'created_by' => NULL,
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at'  => date("Y-m-d H:i:s"),
            'updated_at'  => NULL,
        ]);

        DB::table('roles')->insert([
            'name' => 'Developer',
            'description' => 'Developer',
            'status' => 1,
            'deleted_at' => NULL,
            'created_by' => NULL,
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at'  => date("Y-m-d H:i:s"),
            'updated_at'  => NULL,
        ]);
        DB::table('roles')->insert([
            'name' => 'Others',
            'description' => 'Others',
            'status' => 1,
            'deleted_at' => NULL,
            'created_by' => NULL,
            'updated_by' => NULL,
            'deleted_by' => NULL,
            'created_at'  => date("Y-m-d H:i:s"),
            'updated_at'  => NULL,
        ]);
    }
}
