<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedByOnTranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tranches', function (Blueprint $table) {
            $table->boolean('deleted')->default(false)->after('idSection');
            $table->integer('deleted_by')->after('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tranches', function (Blueprint $table) {
            $table->dropColumn('deleted');
            $table->dropColumn('deleted_by');
        });
    }
}
