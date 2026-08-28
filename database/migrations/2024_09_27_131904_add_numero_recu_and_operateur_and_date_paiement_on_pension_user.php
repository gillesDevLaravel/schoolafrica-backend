<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumeroRecuAndOperateurAndDatePaiementOnPensionUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pension_users', function (Blueprint $table) {
            $table->string('receiptNumber')->nullable()->after('deleted');
            $table->string('operator')->nullable()->after('receiptNumber');
            $table->string('paymentDate')->nullable()->after('operator');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pension_users', function (Blueprint $table) {
            $table->dropColumn('receiptNumber');
            $table->dropColumn('operator');
            $table->dropColumn('paymentDate');
        });
    }
}
