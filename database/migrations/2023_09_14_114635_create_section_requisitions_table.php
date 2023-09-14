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
            $table->integer('status')->nullable();
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
