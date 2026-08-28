<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentalMonitoringTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parental_monitoring', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('comment');
            $table->string('answer');
            $table->integer('idParent')->unsigned();
            $table->integer('idStudent')->unsigned();
            $table->integer('idClasse')->unsigned();
            $table->integer('idSchool')->unsigned();
            $table->integer('idSection')->unsigned();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('idParent')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idStudent')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idClasse')->references('id')->on('classes')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('parental_monitoring');
    }
}
