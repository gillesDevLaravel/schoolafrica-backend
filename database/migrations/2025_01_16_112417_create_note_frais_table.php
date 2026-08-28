<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoteFraisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_frais', function (Blueprint $table) {
            $table->id();
            $table->integer('idUser')->unsigned();
            $table->string('libelle');
            $table->string('amount');
            $table->string('status')->default('create');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->boolean('deleted')->default(false);
            $table->integer('deleted_by')->nullable();
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
        Schema::dropIfExists('note_frais');
    }
}
