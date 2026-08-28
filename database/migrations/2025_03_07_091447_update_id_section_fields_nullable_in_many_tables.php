<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIdSectionFieldsNullableInManyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chapters', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });

        Schema::table('coefficients', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });

        Schema::table('cycles', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });

        Schema::table('fees', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });

        Schema::table('fee_user', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });

        Schema::table('filieres', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });

        Schema::table('homework', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });

        Schema::table('homework_dones', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->nullable()->change();
        });

        Schema::table('lessons', function (Blueprint $table) {
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
        Schema::table('chapters', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });

        Schema::table('coefficients', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });

        Schema::table('cycles', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });

        Schema::table('fees', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });

        Schema::table('fee_user', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });

        Schema::table('filieres', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });

        Schema::table('homework', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });

        Schema::table('homework_dones', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->unsignedInteger('idSection')->change();
        });
    }
}
