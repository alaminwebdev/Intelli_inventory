<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_in_details', function (Blueprint $table) {
            $table->id();
            $table->integer('stock_in_id')->nullable();
            $table->integer('product_information_id')->nullable();
            $table->string('po_no')->nullable();
            $table->date('po_date')->nullable();
            $table->integer('po_qty')->nullable();
            $table->integer('receive_qty')->nullable();
            $table->integer('reject_qty')->nullable();
            $table->integer('available_qty')->nullable();
            $table->integer('dispatch_qty')->nullable();
            $table->integer('prev_receive_qty')->nullable();
            $table->date('mfg_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_in_details');
    }
}
