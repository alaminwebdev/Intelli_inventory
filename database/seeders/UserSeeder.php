<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'       => 'Admin',
            'username'        => NULL,
            'email' => 'admin@gmail.com',
            'mobile' => NULL,
            'email_verified_at' => NULL,
            'status'      => 1,
            'password'      => '$2y$10$fEt5i4g3hzhFlMhAMV/preypehZMwFdRbBcaVHp1zd70G.rx4.r9S',
            'deleted_at' => NULL,
            'image' => NULL,
            'remember_token' => NULL,
            'created_at'  => date("Y-m-d H:i:s"),
            'updated_at'  => NULL,
        ]);

        DB::table('users')->insert([
            'name'       => 'Mamun',
            'username'   => NULL,
            'email' => 'mamun@gmail.com',
            'mobile' => NULL,
            'email_verified_at' => NULL,
            'status'      => 1,
            'password'      => '$2y$10$fEt5i4g3hzhFlMhAMV/preypehZMwFdRbBcaVHp1zd70G.rx4.r9S',
            'deleted_at' => NULL,
            'image' => NULL,
            'remember_token' => NULL,
            'created_at'  => date("Y-m-d H:i:s"),
            'updated_at'  => NULL,
        ]);
    }
}
