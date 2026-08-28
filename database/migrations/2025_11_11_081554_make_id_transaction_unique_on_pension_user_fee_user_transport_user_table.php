<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeIdTransactionUniqueOnPensionUserFeeUserTransportUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // PensionUser
        Schema::table('pension_users', function (Blueprint $table) {
            $table->unique('idTransaction');
        });

        // FeeUser
        Schema::table('fee_user', function (Blueprint $table) {
            $table->unique('idTransaction');
        });

        // TransportUser
//        Schema::table('transport_users', function (Blueprint $table) {
//            $table->unique('idTransaction');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Pension Users
        Schema::table('pension_users', function (Blueprint $table) {
            $table->dropUnique(['idTransaction']);
        });

        // Fee Users
        Schema::table('fee_user', function (Blueprint $table) {
            $table->dropUnique(['idTransaction']);
        });

        // Transport Users
//        Schema::table('transport_users', function (Blueprint $table) {
//            $table->dropUnique(['idTransaction']);
//        });
    }
}
