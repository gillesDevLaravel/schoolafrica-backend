<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->date('date')->nullable();
            $table->integer('idCourse')->unsigned();
            $table->boolean('is_justified')->default(false);            
            $table->integer('idAssessmentType')->unsigned()->nullable();
            $table->integer('idTeacher')->unsigned()->nullable();
            $table->integer('idStudent')->unsigned()->nullable();
            $table->integer('idSchool')->unsigned();
            $table->integer('idSection')->unsigned()->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('idAssessmentType')->references('id')->on('assessment_type')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idTeacher')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idStudent')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idSchool')->references('id')->on('schools')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idSection')->references('id')->on('section')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absences');
    }
}
