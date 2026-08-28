<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReglementInterieursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reglement_interieurs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('idSchool')->unsigned();
            $table->integer('idSection')->unsigned()->nullable();
            $table->integer('created_by'); // celui qui a effectué le règlement intérieur
            $table->integer('updated_by')->nullable(); // celui qui a modifié le règlement intérieur
            $table->boolean('deleted')->default(false);
            $table->integer('deleted_by')->nullable(); // celui qui a supprimé#archivé le règlement intérieur
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
        Schema::dropIfExists('reglement_interieurs');
    }
}
