<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matter', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('libelle')->nullable();
            $table->string('name');
            $table->boolean('assessment')->nullable();
            $table->longText('description')->nullable();
            $table->integer('idOptionLevel')->unsigned()->nullable();
            $table->integer('idSchool')->unsigned();
            $table->integer('idSection')->unsigned();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::create('matter_has_level', function(Blueprint $table){
            $table->increments('id');
            $table->integer('matter_id')->unsigned()->index();
            $table->integer('level_id')->unsigned()->index();
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('matter_id')->references('id')->on('matter')->onDelete('cascade');
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
        Schema::dropIfExists('matter_has_level');
        Schema::dropIfExists('matter');
    }
}
