<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string("reference")->unique();
            $table->unsignedBigInteger("idUser");
            $table->string("type"); // Type de contrat (ex : CDI, CDD, Stage)
            $table->text("description")->nullable();
            $table->date("start_date");
            $table->integer("duration"); //en mois
            $table->string("working_hours"); //au format debut-fin (heure:minutes) ex : 8:00-17:00
            $table->string("position"); // Poste occupé
            $table->decimal("gross_salary", 10, 2); // Salaire brut
            $table->string("status"); // Statut du contrat (ex : "Active", "Terminated")
            $table->string("service_benefits")->nullable(); // Avantages de service
            $table->string("bonus")->nullable(); // Prime
            $table->string("file_link")->nullable();
            $table->integer('deleted')->default(0);
            $table->timestamps();
            $table->unsignedBigInteger("created_by");
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->unsignedBigInteger("deleted_by")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
