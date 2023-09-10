<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_routes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->integer('menu_id');
            $table->string('section_or_route')->nullable();
            $table->integer('sort')->nullable();
            $table->string('route')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

//Seeding table
        DB::table('menu_routes')->insert(
           array(
              array('id' => '1','name' => 'Add','menu_id' => '17','section_or_route' => 'route','sort' => '1','route' => 'admin.role-management.role-info.add','status' => '1','created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'deleted_at' => NULL,'created_at' => '2023-03-06 17:06:58','updated_at' => '2023-03-06 17:06:58'),
              array('id' => '2','name' => 'Edit','menu_id' => '17','section_or_route' => 'route','sort' => '2','route' => 'admin.role-management.role-info.edit','status' => '1','created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'deleted_at' => NULL,'created_at' => '2023-03-06 17:06:58','updated_at' => '2023-03-06 17:06:58'),
              array('id' => '3','name' => 'Delete','menu_id' => '17','section_or_route' => 'route','sort' => '3','route' => 'admin.role-management.role-info.destroy','status' => '1','created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'deleted_at' => NULL,'created_at' => '2023-03-06 17:06:58','updated_at' => '2023-03-06 17:06:58'),
              array('id' => '4','name' => 'Add','menu_id' => '23','section_or_route' => 'route','sort' => '1','route' => 'admin.user-management.user-info.add','status' => '1','created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'deleted_at' => NULL,'created_at' => '2023-03-06 17:08:02','updated_at' => '2023-03-06 17:08:02'),
              array('id' => '5','name' => 'Edit','menu_id' => '23','section_or_route' => 'route','sort' => '2','route' => 'admin.user-management.user-info.edit','status' => '1','created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'deleted_at' => NULL,'created_at' => '2023-03-06 17:08:02','updated_at' => '2023-03-06 17:08:02'),
              array('id' => '6','name' => 'Delete','menu_id' => '23','section_or_route' => 'route','sort' => '3','route' => 'admin.user-management.user-info.destroy','status' => '1','created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'deleted_at' => NULL,'created_at' => '2023-03-06 17:08:02','updated_at' => '2023-03-06 17:08:02')
          )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_routes');
    }
}
