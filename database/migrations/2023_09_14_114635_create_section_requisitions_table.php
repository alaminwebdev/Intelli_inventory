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
            $table->integer('user_id');
            $table->integer('section_id')->nullable();
            $table->integer('status')->nullable()->comment('0=Created, 1=Recommended, 2=Reject, 3=Final Approved, 4=Distributed, 5=Received');
            $table->integer('recommended_by')->nullable();
            $table->dateTime('recommended_at')->nullable();
            $table->integer('final_approve_by')->nullable();
            $table->dateTime('final_approve_at')->nullable();
            $table->integer('distribute_by')->nullable();
            $table->dateTime('distribute_at')->nullable();
            $table->integer('receive_by')->nullable();
            $table->dateTime('receive_at')->nullable();
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
