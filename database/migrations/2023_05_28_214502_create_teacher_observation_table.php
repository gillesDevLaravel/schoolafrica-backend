<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherObservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_observation', function (Blueprint $table) {
            $table->id();
            $table->longText('description');
            $table->integer('idAssessment')->unsigned()->nullable();
            $table->integer('idStudent')->unsigned()->nullable();
            $table->integer('idClasse')->unsigned()->nullable();
            $table->integer('idSchool')->unsigned()->nullable();
            $table->integer('idSection')->unsigned()->nullable();
            $table->integer('idTeacher')->unsigned()->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('idAssessment')->references('id')->on('assessments')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idStudent')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idClasse')->references('id')->on('classes')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idSchool')->references('id')->on('schools')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idSection')->references('id')->on('section')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idTeacher')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_observation');
    }
}
