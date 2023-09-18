<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributeDetailsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('distribute_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id')->nullable();
            $table->bigInteger('distribute_id');
            $table->bigInteger('product_id');
            $table->integer('demand_quantity')->nullable();
            $table->integer('distribute_quantity')->nullable();
            $table->longText('remarks')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('distribute_details');
    }
}
