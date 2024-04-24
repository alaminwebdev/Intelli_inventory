<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerifiedInfoInSectionRequisitionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('section_requisition_details', function (Blueprint $table) {
            $table->integer('verify_quantity')->after('recommended_quantity')->nullable()->comment('verify quantity for approve');
            $table->longText('verify_remarks')->after('recommended_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('section_requisition_details', function (Blueprint $table) {
            $table->dropColumn('verify_quantity');
            $table->dropColumn('verify_remarks');
        });
    }
}
