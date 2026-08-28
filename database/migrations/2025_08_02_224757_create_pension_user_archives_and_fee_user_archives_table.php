<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePensionUserArchivesAndFeeUserArchivesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Vérifie si la table n'existe pas déjà avant de créer
        if (!Schema::hasTable('pension_user_archives')) {
            DB::statement('CREATE TABLE pension_user_archives LIKE pension_users');
        }

        if (!Schema::hasTable('fee_user_archives')) {
            DB::statement('CREATE TABLE fee_user_archives LIKE fee_user');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('pension_user_archives');
        Schema::dropIfExists('fee_user_archives');
    }
}
