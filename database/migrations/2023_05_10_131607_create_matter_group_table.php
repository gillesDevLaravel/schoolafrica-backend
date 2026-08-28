<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatterGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matter_group', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->integer('idOptionLevel')->unsigned()->nullable();
            $table->integer('idSchool')->unsigned();
            $table->integer('idSection')->unsigned();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();            
            $table->timestamps();

            $table->foreign('idOptionLevel')->references('id')->on('option_level')->onDelete('restrict')->onUpdate('restrict'); 
            $table->foreign('idSchool')->references('id')->on('schools')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idSection')->references('id')->on('section')->onDelete('restrict')->onUpdate('restrict'); 
        });

        Schema::create('matter_group_has_matter', function(Blueprint $table){
            $table->increments('id');
            $table->integer('matter_id')->unsigned()->index();
            $table->integer('matter_group_id')->unsigned()->index();
            $table->foreign('matter_id')->references('id')->on('matter')->onDelete('cascade');
            $table->foreign('matter_group_id')->references('id')->on('matter_group')->onDelete('cascade');
        });

        Schema::create('matter_group_has_level', function(Blueprint $table){
            $table->increments('id');
            $table->integer('matter_group_id')->unsigned()->index();
            $table->integer('level_id')->unsigned()->index();
            $table->foreign('matter_group_id')->references('id')->on('matter_group')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matter_group_has_level');
        Schema::dropIfExists('matter_group_has_matter');
        Schema::dropIfExists('matter_group');
    }
}
