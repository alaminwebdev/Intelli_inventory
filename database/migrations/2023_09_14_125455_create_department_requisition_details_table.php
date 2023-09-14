<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentRequisitionDetailsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('department_requisition_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_requisition_id');
            $table->bigInteger('product_id');
            $table->integer('current_stock')->nullable();
            $table->integer('demand_quantity')->nullable();
            $table->integer('recive_quantity')->nullable();
            $table->integer('status')->nullable();
            $table->longText('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('department_requisition_details');
    }
}
