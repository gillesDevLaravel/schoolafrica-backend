<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AugmenterTailleMontantsSurPensionUserEtFeeUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pension_users', function (Blueprint $table) {
            $table->float('advancePayment', 15)->change();
            $table->float('balancePayment', 15)->change();
        });
        Schema::table('fee_user', function (Blueprint $table) {
            $table->float('advancePayment', 15)->change();
            $table->float('balancePayment', 15)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
