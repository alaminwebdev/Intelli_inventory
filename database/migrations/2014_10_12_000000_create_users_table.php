<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('mobile_no')->unique()->nullable();
            $table->string('designation_id')->nullable();
            $table->string('working_place')->nullable();
            $table->string('image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('status')->default(0);
            $table->rememberToken();
            $table->integer('sort')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

//Seeding table
    DB::table('users')->insert(
        array(
            array('id' => '1','name' => 'Developer','email' => 'dev@nanoit.biz','image' => NULL,'email_verified_at' => NULL,'password' => bcrypt('dev@nano'),'status' => 1,'remember_token' => NULL,'created_at' => '2022-12-14 04:44:30','updated_at' => '2022-12-14 04:44:30')
        )
    );
    echo "user credential".PHP_EOL."email: dev@nanoit.biz".PHP_EOL."password: dev@nano".PHP_EOL;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
