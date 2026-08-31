<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->double('value');
            $table->string('observation')->nullable();
            $table->integer('notemax')->nullable();
            $table->integer('idCoeficient')->unsigned()->nullable();
            $table->integer('idMatter')->unsigned();
            $table->integer('idStudent')->unsigned();
            $table->integer('idClasse')->unsigned();
            $table->integer('idAssessment')->unsigned();
            $table->integer('idAssessmentType')->unsigned();
            $table->integer('idTypeEvaluation')->unsigned()->nullable();
            $table->integer('idSchool')->unsigned();
            $table->integer('idSection')->unsigned();
            $table->integer('idTeacher')->unsigned()->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();            
            $table->timestamps();

            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.

            // $table->foreign('idCoeficient')->references('id')->on('coefficients')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idMatter')->references('id')->on('matter')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idStudent')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idClasse')->references('id')->on('classes')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idAssessment')->references('id')->on('assessments')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idAssessmentType')->references('id')->on('assessment_type')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idTypeEvaluation')->references('id')->on('type_evaluation')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idSchool')->references('id')->on('schools')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idSection')->references('id')->on('section')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idTeacher')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
