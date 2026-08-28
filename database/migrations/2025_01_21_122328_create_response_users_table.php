<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponseUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response_users', function (Blueprint $table) {
            $table->id();
            $table->integer('idUser')->unsigned();
            $table->integer('idQuestionnaire')->unsigned(); // une question est liée à une évaluation (assessment)
            $table->integer('idAssessment')->unsigned(); // juste pour un accès rapide des données
            $table->string('response');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('response_users');
    }
}
