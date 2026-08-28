<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionIdToFeeUserAndPensionUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fee_user', function (Blueprint $table) {
            $table->unsignedInteger('idTransaction')->nullable()->unique()->after('id');
        });
        Schema::table('pension_users', function (Blueprint $table) {
            $table->unsignedInteger('idTransaction')->nullable()->unique()->after('id');
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
            $table->dropColumn('idTransaction');
        });
        Schema::table('pension_users', function (Blueprint $table) {
            $table->dropColumn('idTransaction');
        });
    }
}
