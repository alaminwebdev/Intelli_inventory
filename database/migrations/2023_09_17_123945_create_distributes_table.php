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
            $table->bigInteger('department_id')->nullable();
            $table->string('requisition_no');
            $table->integer('status')->nullable()->comment("1=approved, 2=distribute");
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
        Schema::dropIfExists('distributes');
    }
}
