<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdUserApproveAndChangeRetourToPermissionsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions_users', function (Blueprint $table) {
            $table->dateTime('retour')->nullable()->change();
            $table->unsignedBigInteger('idUserApprove')->nullable()->after('idUser');
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
            $table->integer('duration')->nullable(false)->change();
            $table->dropColumn('idUserApprove');
        });
    }
}
