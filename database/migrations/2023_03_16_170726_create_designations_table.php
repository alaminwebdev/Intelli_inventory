<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignationsTable extends Migration
{
/**
* Run the migrations.
*
* @return void
*/
public function up()
{
      Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort');
            $table->timestamps();
      });

//Seeding table
      DB::table('designations')->insert(
            array(
                  array('id' => '1','name' => 'সিস্টেম ম্যানেজার','sort' => '1','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '2','name' => 'সিস্টেম এনালিস্ট','sort' => '2','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '3','name' => 'সিনিয়র সিস্টেম এনালিস্ট','sort' => '3','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '4','name' => 'সিনিয়র রক্ষণাবেক্ষন প্রকৌশলী','sort' => '4','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '5','name' => 'সিনিয়র মেইনটেন্যান্স ইঞ্জিনিয়ার','sort' => '5','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '6','name' => 'সিনিয়র প্রোগ্রামার','sort' => '6','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '7','name' => 'সিনিয়র কম্পিউটার অপারেটর','sort' => '6','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '8','name' => 'সহকারী রক্ষণাবেক্ষন প্রকৌশলী','sort' => '6','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '9','name' => 'সহকারী মেইনটেন্যান্স ইঞ্জিনিয়ার','sort' => '6','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '10','name' => 'সহকারী প্রোগ্রামার','sort' => '6','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '11','name' => 'সহকারী নেটওয়ার্ক ইঞ্জিনিয়ার','sort' => '6','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '12','name' => 'রক্ষণাবেক্ষন প্রকৌশলী','sort' => '6','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '13','name' => 'মেইনটেন্যান্স ইঞ্জিনিয়ার','sort' => '6','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '14','name' => 'প্রোগ্রামার','sort' => '6','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '15','name' => 'নেটওয়ার্ক ইঞ্জিনিয়ার','sort' => '6','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '16','name' => 'ডাটাবেজ এডমিনিস্ট্রেটর','sort' => '6','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '17','name' => 'কম্পিউটার অপারেশন সুপারভাইজার','sort' => '6','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02'),
                  array('id' => '18','name' => 'ওয়েবসাইট এ্যাডমিনিস্ট্রেটর','sort' => '6','created_at' => '2023-03-16 17:27:02','updated_at' => '2023-03-16 17:27:02')
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
      Schema::dropIfExists('designations');
}
}
