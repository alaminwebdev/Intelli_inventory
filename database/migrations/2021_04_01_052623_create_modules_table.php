<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
public function up()
{
    Schema::create('modules', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('name')->nullable();
        $table->tinyInteger('status')->default(1);
        $table->integer('sort')->nullable();
        $table->string('color')->nullable();
        $table->integer('created_by')->nullable();
        $table->integer('updated_by')->nullable();
        $table->integer('deleted_by')->nullable();
        $table->softDeletes();
        $table->timestamps();
    });

//Seeding table
    DB::table('modules')->insert(
        array(
            array('id' => '1','name' => 'Moduleless','status' => '1','sort' => NULL,'color' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-12-15 13:43:53','updated_at' => '2022-12-15 13:43:53'),
            array('id' => '2','name' => 'Master setup','status' => '1','sort' => NULL,'color' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_by' => NULL,'deleted_at' => NULL,'created_at' => '2022-12-15 13:43:53','updated_at' => '2022-12-15 13:43:53')
        )
    );
}

public function down()
{
    Schema::dropIfExists('modules');
}
}
