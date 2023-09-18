<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('distributes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_requisition_id');
            $table->bigInteger('product_id');
            $table->bigInteger('stock_in_detail_id');
            $table->integer('distribute_quantity');
            $table->integer('distribute_by');
            $table->dateTime('distribute_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('distributes');
    }
}
