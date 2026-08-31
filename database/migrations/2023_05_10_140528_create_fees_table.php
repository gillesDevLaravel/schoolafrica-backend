<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->date('deadline');
            $table->integer('idOptionLevel')->unsigned()->nullable();
            $table->integer('idSchool')->unsigned();
            $table->integer('idSection')->unsigned();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.

            // $table->foreign('idOptionLevel')->references('id')->on('option_level')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idSchool')->references('id')->on('schools')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idSection')->references('id')->on('section')->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('fee_has_level', function(Blueprint $table){
            $table->increments('id');
            $table->integer('fee_id')->unsigned()->index();
            $table->integer('level_id')->unsigned()->index();
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('fee_id')->references('id')->on('fees')->onDelete('cascade');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_has_level');
        Schema::dropIfExists('fees');
    }
}
