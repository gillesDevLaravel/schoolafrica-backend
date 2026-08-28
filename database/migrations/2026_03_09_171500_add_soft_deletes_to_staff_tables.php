<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToStaffTables extends Migration
{
    public function up(): void
    {
        Schema::table('type_evaluation', function (Blueprint $table) {
            if (!Schema::hasColumn('type_evaluation', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('progressions', function (Blueprint $table) {
            if (!Schema::hasColumn('progressions', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('sanctions', function (Blueprint $table) {
            if (!Schema::hasColumn('sanctions', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('semestres', function (Blueprint $table) {
            if (!Schema::hasColumn('semestres', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('type_evaluation', function (Blueprint $table) {
            if (Schema::hasColumn('type_evaluation', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('progressions', function (Blueprint $table) {
            if (Schema::hasColumn('progressions', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('sanctions', function (Blueprint $table) {
            if (Schema::hasColumn('sanctions', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('semestres', function (Blueprint $table) {
            if (Schema::hasColumn('semestres', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
