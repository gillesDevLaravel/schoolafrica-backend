<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdOptionLevelToSchoolsExamsTable extends Migration
{
    public function up()
    {
        Schema::table('schools_exams', function (Blueprint $table) {
            $table->unsignedInteger('idOptionLevel')->nullable()->after('idAssessmentType');
        });
    }

    public function down()
    {
        Schema::table('schools_exams', function (Blueprint $table) {
            $table->dropColumn('idOptionLevel');
        });
    }
}
