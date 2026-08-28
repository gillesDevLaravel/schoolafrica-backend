<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToMultipleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('courses', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('requetes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('absences', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('presence_teacher', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('absences', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('presence_teacher', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('requetes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('courses', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
