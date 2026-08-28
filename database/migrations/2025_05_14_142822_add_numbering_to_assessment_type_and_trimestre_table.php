<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumberingToAssessmentTypeAndTrimestreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessment_type', function (Blueprint $table) {
            $table->integer('numbering')->nullable()->after('name');
        });
        Schema::table('trimestre', function (Blueprint $table) {
            $table->integer('numbering')->nullable()->after('name');
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
            $table->dropColumn('numbering');
        });
        Schema::table('trimestre', function (Blueprint $table) {
            $table->dropColumn('numbering');
        });
    }
}
