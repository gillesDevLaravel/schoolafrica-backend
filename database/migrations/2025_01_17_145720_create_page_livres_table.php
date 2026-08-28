<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageLivresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_livres', function (Blueprint $table) {
            $table->id();
            $table->integer('idBook')->unsigned();
            $table->string('titre');
            $table->string('sous_titre')->nullable();
            $table->text('description');
            $table->integer('created_by');
            $table->boolean('deleted')->default(false);
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('page_livres');
    }
}
