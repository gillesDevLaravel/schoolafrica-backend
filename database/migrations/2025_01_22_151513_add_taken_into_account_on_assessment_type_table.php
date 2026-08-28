<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTakenIntoAccountOnAssessmentTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessment_type', function (Blueprint $table) {
            $table->boolean('takenIntoAccount')->default(false)->after('idSection');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessment_type', function (Blueprint $table) {
            $table->dropColumn('takenIntoAccount');
        });
    }
}
