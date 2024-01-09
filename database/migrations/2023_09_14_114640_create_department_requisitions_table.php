<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentRequisitionsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('department_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('requisition_no');
            $table->bigInteger('user_id');
            $table->integer('department_id')->nullable();
            $table->integer('status')->nullable()->comment('0=created, 1=Dep.approved, 2=reject, 3=Final Approved');
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
        Schema::dropIfExists('department_requisitions');
    }
}
