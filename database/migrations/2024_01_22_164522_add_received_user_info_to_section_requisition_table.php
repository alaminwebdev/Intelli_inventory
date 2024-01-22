<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceivedUserInfoToSectionRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('section_requisitions', function (Blueprint $table) {
            $table->string('name')->after('receive_at')->comment('Received Person Name')->nullable();
            $table->string('designation')->after('name')->comment('Received Person Designation')->nullable();
            $table->string('phone')->after('designation')->comment('Received Person Phone')->nullable();
            $table->string('email')->after('phone')->comment('Received Person Email')->nullable();
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
            $table->dropColumn('name');
            $table->dropColumn('designation');
            $table->dropColumn('phone');
            $table->dropColumn('email');
        });
    }
}
