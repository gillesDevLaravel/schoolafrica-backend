<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLangOnSectionAndOptionLevelTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('section', function (Blueprint $table) {
            $table->string('lang')->nullable()->after('description');
        });
        Schema::table('option_level', function (Blueprint $table) {
            $table->string('lang')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('section', function (Blueprint $table) {
            $table->dropColumn('lang');
        });
        Schema::table('option_level', function (Blueprint $table) {
            $table->dropColumn('lang');
        });
    }
}
