<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreationDeLaTablePermissionUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("permissions_users", function (Blueprint $table) {
            $table->id();
            $table->string("raison");             // Champ pour la raison de la permission
            $table->date("depart");              // Date de départ
            $table->date("retour");              // Date de retour
            $table->bigInteger("created_by");    // ID de l'utilisateur qui crée la permission
            $table->bigInteger("updated_by")->nullable();  // ID de l'utilisateur qui a mis à jour la permission (nullable)
            $table->string("statut")->nullable(); // Statut de la permission, nullable
            $table->softDeletes();              // Pour gérer le soft delete
            $table->timestamps();               // Pour les dates created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("permissions_users"); // Référence correcte à la table permissions_users
    }
}
