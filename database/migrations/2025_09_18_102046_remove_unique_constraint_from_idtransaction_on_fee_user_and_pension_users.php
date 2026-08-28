<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueConstraintFromIdtransactionOnFeeUserAndPensionUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fee_user', function (Blueprint $table) {
            // Supprimer la contrainte unique sur idTransaction
            $table->dropUnique('fee_user_idtransaction_unique');

            // On garde la colonne, mais sans unique
            $table->unsignedInteger('idTransaction')->nullable()->change();
        });

        Schema::table('pension_users', function (Blueprint $table) {
            // Supprimer la contrainte unique sur idTransaction
            $table->dropUnique('pension_users_idtransaction_unique');

            $table->unsignedInteger('idTransaction')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fee_user', function (Blueprint $table) {
            $table->unsignedInteger('idTransaction')->nullable()->unique()->change();
        });

        Schema::table('pension_users', function (Blueprint $table) {
            $table->unsignedInteger('idTransaction')->nullable()->unique()->change();
        });
    }
}
