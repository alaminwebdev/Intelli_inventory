<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_super_power')->default(0);
            $table->integer('sort')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

//Seeding table
        DB::table('roles')->insert(
            array(
                array('id' => '1','name' => 'Developer','description' => NULL,'status' => '1','is_super_power' => '1','sort' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'deleted_at' => NULL,'created_at' => NULL,'updated_at' => NULL),
                array('id' => '2','name' => 'Super Admin','description' => NULL,'status' => '1','is_super_power' => '1','sort' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'deleted_at' => NULL,'created_at' => NULL,'updated_at' => NULL)
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
        Schema::dropIfExists('roles');
    }
}
