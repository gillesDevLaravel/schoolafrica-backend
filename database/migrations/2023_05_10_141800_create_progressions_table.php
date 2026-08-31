<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progressions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->integer('nbrModules')->nullable();
            $table->string('status')->nullable();
            $table->integer('idClasse')->unsigned()->nullable();
            $table->integer('idSchool')->unsigned();
            $table->integer('idSection')->unsigned();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.

            // $table->foreign('idClasse')->references('id')->on('classes')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idSchool')->references('id')->on('schools')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idSection')->references('id')->on('section')->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('progressions_has_classes', function(Blueprint $table){
            $table->increments('id');
            $table->integer('progression_id')->unsigned()->index();
            $table->integer('classes_id')->unsigned()->index();
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('progression_id')->references('id')->on('progressions')->onDelete('cascade');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('classes_id')->references('id')->on('classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('progressions');
    }
}
