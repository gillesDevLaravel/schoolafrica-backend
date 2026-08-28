<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->integer('idUser')->unsigned();
            $table->integer('idBook')->unsigned();
            $table->string('date_sortie');
            $table->string('date_retour')->nullable();
            $table->enum('status', ['in_progress', 'finished'])->default('in_progress');
            $table->string('reason')->nullable();
            $table->string('observation')->nullable();
            $table->integer('idSchool')->unsigned()->nullable();
            $table->integer('idSection')->unsigned()->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
