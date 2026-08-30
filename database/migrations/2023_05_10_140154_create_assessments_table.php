<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->time('hour')->nullable();
            $table->integer('duration')->nullable();
            $table->string('day')->nullable();
            $table->date('date')->nullable();
            $table->integer('notemax')->nullable();
            $table->integer('oral')->nullable();
            $table->integer('orale')->nullable();
            $table->integer('ecrit')->nullable();
            $table->integer('written')->nullable();
            $table->integer('attitude')->nullable();
            $table->integer('savoir_etre')->nullable();
            $table->integer('pratical')->nullable();
            $table->integer('pratique')->nullable();            
            $table->integer('idCoeficient')->unsigned()->nullable();
            $table->integer('idMatter')->unsigned()->nullable();
            $table->integer('idClasse')->unsigned()->nullable();
            $table->integer('idTeacher')->unsigned()->nullable();
            $table->integer('idSchool')->unsigned()->nullable();
            $table->integer('idSection')->unsigned()->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.

            // $table->foreign('idCoeficient')->references('id')->on('coefficients')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idMatter')->references('id')->on('matter')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idClasse')->references('id')->on('classes')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idTeacher')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idSchool')->references('id')->on('schools')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idSection')->references('id')->on('section')->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('assessments_has_type_evaluation', function(Blueprint $table){
            $table->increments('id');
            $table->integer('assessment_id')->unsigned()->index();
            $table->integer('type_evaluation_id')->unsigned()->index();
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('assessment_id')->references('id')->on('assessments')->onDelete('cascade');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('type_evaluation_id')->references('id')->on('type_evaluation')->onDelete('cascade');
        });

        Schema::create('assessments_has_assessment_type', function(Blueprint $table){
            $table->increments('id');
            $table->integer('assessment_id')->unsigned()->index();
            $table->integer('assessment_type_id')->unsigned()->index();
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('assessment_id')->references('id')->on('assessments')->onDelete('cascade');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('assessment_type_id')->references('id')->on('assessment_type')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessments_has_assessment_type');
        Schema::dropIfExists('assessments_has_type_evaluation');
        Schema::dropIfExists('assessments');
    }
}
