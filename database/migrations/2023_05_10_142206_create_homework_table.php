<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homework', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('deadline');
            $table->longText('description')->nullable();
            $table->string('answer')->nullable();
            $table->string('status')->nullable();
            $table->integer('idClasse')->unsigned();
            $table->integer('idMatter')->unsigned();
            $table->integer('idTeacher')->unsigned()->nullable();
            $table->integer('idSchool')->unsigned();
            $table->integer('idSection')->unsigned();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();            
            $table->timestamps();

            $table->foreign('idClasse')->references('id')->on('classes')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('homework');
    }
}
