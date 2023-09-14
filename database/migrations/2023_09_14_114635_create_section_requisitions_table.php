<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionRequisitionsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('section_requisitions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_requisition_id')->nullable();
            $table->string('requisition_no');
            $table->bigInteger('user_id');
            $table->bigInteger('category_id');
            $table->bigInteger('product_id');
            $table->integer('current_stock')->nullable();
            $table->integer('demand_quantity')->nullable();
            $table->integer('status')->nullable();
            $table->longText('remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('section_requisitions');
    }
}
