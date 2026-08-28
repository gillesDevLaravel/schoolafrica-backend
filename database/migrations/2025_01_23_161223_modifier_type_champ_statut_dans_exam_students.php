<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifierTypeChampStatutDansExamStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_students', function (Blueprint $table) {
            if (Schema::hasColumn('exam_students', 'statut')) {
                $table->string('statut')->change();
            }
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
            if (Schema::hasColumn('exam_students', 'statut')) {
                $table->integer('statut')->change();
            }
        });
    }
}
