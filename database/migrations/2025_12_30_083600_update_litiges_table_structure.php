<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLitigesTableStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('litiges', function (Blueprint $table) {

            /* ===============================
             * Renommage des colonnes
             * =============================== */
            if (Schema::hasColumn('litiges', 'titre')) {
                $table->renameColumn('titre', 'name');
            }

            if (Schema::hasColumn('litiges', 'resolution')) {
                $table->renameColumn('resolution', 'answer');
            }

            /* ===============================
             * Ajout des nouvelles colonnes
             * =============================== */
            if (!Schema::hasColumn('litiges', 'is_anonymous')) {
                $table->boolean('is_anonymous')
                    ->default(false)
                    ->after('description');
            }

            if (!Schema::hasColumn('litiges', 'user_id')) {
                $table->unsignedBigInteger('user_id')
                    ->nullable()
                    ->after('is_anonymous');
            }

            if (!Schema::hasColumn('litiges', 'created_by')) {
                $table->unsignedBigInteger('created_by')
                    ->nullable()
                    ->after('user_id');
            }

            /* ===============================
             * Suppression de colonne obsolète
             * =============================== */
            if (Schema::hasColumn('litiges', 'statut')) {
                $table->dropColumn('statut');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('litiges', function (Blueprint $table) {

            /* ===============================
             * Suppression des colonnes ajoutées
             * =============================== */
            if (Schema::hasColumn('litiges', 'created_by')) {
                $table->dropColumn('created_by');
            }

            if (Schema::hasColumn('litiges', 'user_id')) {
                $table->dropColumn('user_id');
            }

            if (Schema::hasColumn('litiges', 'is_anonymous')) {
                $table->dropColumn('is_anonymous');
            }

            /* ===============================
             * Restauration des anciens noms
             * =============================== */
            if (Schema::hasColumn('litiges', 'name')) {
                $table->renameColumn('name', 'titre');
            }

            if (Schema::hasColumn('litiges', 'answer')) {
                $table->renameColumn('answer', 'resolution');
            }

            /* ===============================
             * Restauration optionnelle de statut
             * =============================== */
            if (!Schema::hasColumn('litiges', 'statut')) {
                $table->string('statut')->nullable();
            }
        });
    }

}
