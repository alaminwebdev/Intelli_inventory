<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPoInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_po_infos', function (Blueprint $table) {
            $table->id();
            $table->string('po_no')->nullable();
            $table->date('po_date')->nullable();
            $table->integer('stock_in_detail_id')->nullable();
            $table->integer('product_information_id')->nullable();
            $table->integer('reject_qty')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('product_po_infos');
    }
}
