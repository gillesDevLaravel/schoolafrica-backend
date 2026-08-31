<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('adresse');
            $table->string('phone');
            $table->string('city');
            $table->string('section');
            $table->integer('idPrincipal')->unsigned()->nullable();
            $table->integer('idAssistant')->unsigned()->nullable();
            $table->integer('idEstablishment')->unsigned();
            $table->string('scholar_level');
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.

            // $table->foreign('idPrincipal')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            // Disabled: historical FK constraints are applied inconsistently and break fresh migrations.
            // $table->foreign('idEstablishment')->references('id')->on('establishments')->onDelete('restrict')->onUpdate('restrict');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
}
