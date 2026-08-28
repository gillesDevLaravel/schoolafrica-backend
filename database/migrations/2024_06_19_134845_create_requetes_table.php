<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requetes', function (Blueprint $table) {
            $table->id();
            $table->string("libelle");
            $table->string("description");
            $table->string("type");
            $table->enum("statut", ['en_cours', 'valide', 'rejected'])->default('en_cours');
            $table->integer("idStudent")->unsigned()->nullable();
            $table->integer("idParent")->unsigned()->nullable();
            $table->integer("idSection")->unsigned()->nullable();
            $table->integer("idSchool")->unsigned()->nullable();
            $table->integer('created_by')->unsigned()->nullable();
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
        Schema::dropIfExists('requetes');
    }
}
