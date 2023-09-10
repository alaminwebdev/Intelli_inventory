<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            'created_at'  => date("Y-m-d H:i:s"),
            'updated_at'  => NULL,
        ]);
    }
}
