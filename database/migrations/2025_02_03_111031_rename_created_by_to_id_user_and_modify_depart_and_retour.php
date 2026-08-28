<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCreatedByToIdUserAndModifyDepartAndRetour extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions_users', function (Blueprint $table) {
            $table->renameColumn("created_by", "idUser");
            $table->dateTime("depart")->change();
            $table->dateTime("retour")->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions_users', function (Blueprint $table) {
            $table->renameColumn("idUser", "created_by");
            $table->date('depart')->change();
            $table->date('retour')->change();
        });
    }
}
