<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoveNumberDaysOffFromUsersToContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->integer('number_days_off')->unsigned()->default(0)->after('bonus');
        });

        Schema::table('users', function (Blueprint $table){
            $table->dropColumn('number_days_off');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('number_days_off')->unsigned()->default(0)->after('bank_rib');
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('number_days_off');
        });
    }
}
