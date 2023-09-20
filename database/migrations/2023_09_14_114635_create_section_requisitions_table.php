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
            $table->integer('section_id')->nullable();
            $table->integer('status')->nullable()->comment('0=Created, 1=Recommended, 2=Reject, 3=Final Approved, 4=Distributed');
            $table->bigInteger('final_approve_by')->nullable();
            $table->dateTime('final_created_at')->nullable();
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
