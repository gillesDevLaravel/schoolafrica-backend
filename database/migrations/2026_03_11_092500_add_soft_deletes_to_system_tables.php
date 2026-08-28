<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToSystemTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        // Ajouter softDeletes à la table packages
        Schema::table('packages', function (Blueprint $table) {
            if (!Schema::hasColumn('packages', 'deleted_at')) {
                $table->softDeletes();
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

        // Supprimer softDeletes de la table packages
        Schema::table('packages', function (Blueprint $table) {
            if (Schema::hasColumn('packages', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });


    }
};
