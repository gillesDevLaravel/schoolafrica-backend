<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScanReceiptIdToFeeUserAndPensionUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fee_user', function (Blueprint $table) {
            $table->unsignedInteger('idScanReceipt')->nullable()->after('idFee');
        });
        Schema::table('pension_users', function (Blueprint $table) {
            $table->unsignedInteger('idScanReceipt')->nullable()->after('idTranche');
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
            $table->dropColumn('idScanReceipt');
        });
        Schema::table('pension_users', function (Blueprint $table) {
            $table->dropColumn('idScanReceipt');
        });
    }
}
