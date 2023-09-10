<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('menus')->insert([
            'name'       => 'Menu Management',
            'parent'     => 0,
            'route'      => 'menu',
            'sort'       => 1,
            'status'     => 0,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'Menu List',
            'parent'     => 1,
            'route'      => 'menu',
            'sort'       => 1,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'Menu Icon',
            'parent'     => 1,
            'route'      => 'menu.icon',
            'sort'       => 2,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'User Management',
            'parent'     => 0,
            'route'      => 'user',
            'sort'       => 1,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'View Users',
            'parent'     => 4,
            'route'      => 'user',
            'sort'       => 1,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'User Roles',
            'parent'     => 4,
            'route'      => 'user.role',
            'sort'       => 2,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'Menu Permission',
            'parent'     => 4,
            'route'      => 'user.permission',
            'sort'       => 3,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'Profile Management',
            'parent'     => 0,
            'route'      => 'profile-management',
            'sort'       => 3,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'Change Password',
            'parent'     => 8,
            'route'      => 'profile-management.change.password',
            'sort'       => 1,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'Change Profile',
            'parent'     => 8,
            'route'      => 'profile-management.change.profile',
            'sort'       => 2,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'HomePages',
            'parent'     => 0,
            'route'      => 'homepages',
            'sort'       => 4,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'Slider',
            'parent'     => 11,
            'route'      => 'homepages.slider.view',
            'sort'       => 1,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'Image Gallery',
            'parent'     => 11,
            'route'      => 'homepages.gallery',
            'sort'       => 2,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'Events',
            'parent'     => 11,
            'route'      => 'homepages.event',
            'sort'       => 4,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'Notice',
            'parent'     => 11,
            'route'      => 'homepages.notice',
            'sort'       => 5,
            'status'     => 0,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'News',
            'parent'     => 11,
            'route'      => 'homepages.news',
            'sort'       => 5,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'Video Gallery',
            'parent'     => 11,
            'route'      => 'homepages.video.gallery',
            'sort'       => 3,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'Site Menu',
            'parent'     => 0,
            'route'      => 'frontend-menu',
            'sort'       => 3,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'Menu Post',
            'parent'     => 18,
            'route'      => 'frontend-menu.post.view',
            'sort'       => 2,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
        DB::table('menus')->insert([
            'name'       => 'Menu View',
            'parent'     => 18,
            'route'      => 'frontend-menu.menu.view',
            'sort'       => 3,
            'status'     => 1,
            'icon'       => NULL,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => NULL,
        ]);
    }
}
