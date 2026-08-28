<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdSectionNullableOnManyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matter', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });
        Schema::table('levels', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });
        Schema::table('matter_group', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });
        Schema::table('modules', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });
        Schema::table('option_level', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });
        Schema::table('parental_monitoring', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });
        Schema::table('pensions', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });
        Schema::table('pension_users', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });
        Schema::table('progressions', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });
        Schema::table('topics', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });
        Schema::table('tranches', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matter', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });
        Schema::table('levels', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });
        Schema::table('matter_group', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });
        Schema::table('modules', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });
        Schema::table('option_level', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });
        Schema::table('parental_monitoring', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });
        Schema::table('pensions', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });
        Schema::table('pension_users', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });
        Schema::table('progressions', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });
        Schema::table('topics', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });
        Schema::table('tranches', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });
    }
}
