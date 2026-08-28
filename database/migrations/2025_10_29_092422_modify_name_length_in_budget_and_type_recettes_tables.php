<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyNameLengthInBudgetAndTypeRecettesTables extends Migration

{
    /**
     * Tables concernées.
     */
    protected $tables = [
        'budgets',
        'type_of_recipes',
    ];

    /**
     * Exécuter la migration.
     */
    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasColumn($table, 'name')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->string('name', 500)->change();
                });
            }
        }
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasColumn($table, 'name')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->string('name', 125)->change();
                });
            }
        }
    }
};
