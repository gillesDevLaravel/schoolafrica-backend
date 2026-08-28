<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->integer('nbrChapters');
            $table->integer('duration');
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->string('status');
            $table->longText('observation')->nullable();
            $table->integer('idProgression')->unsigned();
            $table->integer('idMatter')->unsigned()->nullable();
            $table->integer('idTeacher')->unsigned()->nullable();
            $table->integer('idSchool')->unsigned();
            $table->integer('idSection')->unsigned();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('idProgression')->references('id')->on('progressions')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idMatter')->references('id')->on('matter')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idTeacher')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('modules');
    }
}
