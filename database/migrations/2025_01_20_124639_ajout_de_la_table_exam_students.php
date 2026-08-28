<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AjoutDeLaTableExamStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("exam_students", function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger("idAssessment");  // Utilisation de unsignedBigInteger
            $table->unsignedBigInteger("idAssessmentType");  // Utilisation de unsignedBigInteger
            $table->unsignedBigInteger("idUser");  // Utilisation de unsignedBigInteger
            $table->string("statut")->default("invalid");
            $table->timestamps();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->boolean("deleted")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_students');
    }
}
