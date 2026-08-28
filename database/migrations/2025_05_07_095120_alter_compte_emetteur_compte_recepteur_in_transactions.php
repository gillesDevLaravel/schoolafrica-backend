<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCompteEmetteurCompteRecepteurInTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('compteEmeteur')->change();
            $table->unsignedBigInteger('compteRecepteur')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('compteEmeteur')->unsigned()->nullable();
            $table->integer('compteRecepteur')->unsigned()->nullable();
        });
    }
}
