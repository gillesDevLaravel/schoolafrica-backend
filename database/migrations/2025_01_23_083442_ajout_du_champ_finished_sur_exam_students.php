<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AjoutDuChampFinishedSurExamStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_students', function (Blueprint $table) {
            $table->boolean("finished")->default(false)->after("statut");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_students', function (Blueprint $table) {
            $table->dropColumn('finished');
        });
    }
}
