<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClasseIdToSchoolSupplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_supply', function (Blueprint $table) {
            $table->unsignedInteger('classe_id')->nullable()->after('idSection');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_supply', function (Blueprint $table) {
            $table->dropColumn('classe_id');
        });
    }
}
