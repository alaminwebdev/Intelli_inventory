<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerifiedInfoInSectionRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('section_requisitions', function (Blueprint $table) {
            $table->integer('verify_by')->after('receive_at')->nullable();
            $table->dateTime('verify_at')->after('verify_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('section_requisitions', function (Blueprint $table) {
            $table->dropColumn('verify_by');
            $table->dropColumn('verify_at');
        });
    }
}
