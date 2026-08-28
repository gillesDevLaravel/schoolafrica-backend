<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClasseSchoolSupplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classe_school_supply', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('classe_id');
            $table->unsignedInteger('school_supply_id');
        });

        Schema::table('school_supply', function (Blueprint $table) {
            $table->dropColumn('classe_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classe_school_supply');

        Schema::table('school_supply', function (Blueprint $table) {
            $table->unsignedInteger('classe_id')->nullable()->after('idSection');
        });
    }
}
