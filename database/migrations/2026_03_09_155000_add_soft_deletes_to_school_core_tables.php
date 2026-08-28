<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToSchoolCoreTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = [
            'establishments',
            'schools',
            'campus',
            'section',
            'cycles',
            'levels',
            'option_level',
            'classes',
            'matter',
            'matter_group',
            'assessment_type',
            'trimestre',
            'type_requetes',
            'books',
            'locations',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'deleted_at')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->softDeletes();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = [
            'locations',
            'books',
            'type_requetes',
            'trimestre',
            'assessment_type',
            'matter_group',
            'matter',
            'classes',
            'option_level',
            'levels',
            'cycles',
            'section',
            'campus',
            'schools',
            'establishments',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'deleted_at')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropSoftDeletes();
                });
            }
        }
    }
}
