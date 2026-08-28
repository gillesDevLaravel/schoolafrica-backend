<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAndChangeIdScanReceiptInPensionUsersAndFeeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fee_user', function (Blueprint $table) {
            $table->renameColumn('idScanReceipt', 'scanReceipt');
        });
        Schema::table('fee_user', function (Blueprint $table) {
            $table->string('scanReceipt')->change();
        });

        Schema::table('pension_users', function (Blueprint $table) {
            $table->renameColumn('idScanReceipt', 'scanReceipt');
        });
        Schema::table('pension_users', function (Blueprint $table) {
            $table->string('scanReceipt')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        // fee_user : rollback rename + type
        Schema::table('fee_user', function (Blueprint $table) {
            $table->renameColumn('scanReceipt', 'idScanReceipt');
        });
        Schema::table('fee_user', function (Blueprint $table) {
            $table->integer('idScanReceipt')->change(); // Ajuster si ce n'était pas integer
        });

        // pension_users : rollback rename + type
        Schema::table('pension_users', function (Blueprint $table) {
            $table->renameColumn('scanReceipt', 'idScanReceipt');
        });
        Schema::table('pension_users', function (Blueprint $table) {
            $table->integer('idScanReceipt')->change(); // Ajuster si ce n'était pas integer
        });
    }
}
