<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVarcharToTextInMultipleTables extends Migration
{
    protected $tables = [
        'cycles',
        'levels',
        'option_level',
        'classes',
        'coefficients',
        'requetes',
        'logs',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasColumn($table, 'description')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->text('description')->change();
                });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasColumn($table, 'description')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->string('description', 125)->change();
                });
            }
        }
    }
}

