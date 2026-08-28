<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresenceTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presence_teacher', function (Blueprint $table) {
            $table->id();
            $table->integer('idTeacher')->unsigned();
            $table->date('date')->nullable();
            $table->time('hour')->nullable();
            $table->time('arrivalTime')->nullable();
            $table->time('departureTime')->nullable();
            $table->integer('idCourse')->unsigned()->nullable();
            $table->integer('idSchool')->unsigned()->nullable();
            $table->integer('idSection')->unsigned()->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('idCourse')->references('id')->on('courses')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('presence_teacher');
    }
}
