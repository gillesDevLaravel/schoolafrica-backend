<?php

use App\Enums\BudgetTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAndFieldToBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Modification de la table budgets
        Schema::table('budgets', function (Blueprint $table) {
            $table->enum('type', BudgetTypeEnum::values())->after('name');

            $table->dropColumn(['type_invoice_id', 'amount', 'quantity']);
        });

        // Création de la table pivot budget_type_invoice
        Schema::create('budget_type_invoice', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('budget_id');
            $table->unsignedBigInteger('type_invoice_id');
            $table->integer('quantity')->default(1);
            $table->integer('number')->default(1);
            $table->decimal('amount', 15, 2);
        });

        // Création de la table pivot budget_type_of_recipe
        Schema::create('budget_type_of_recipe', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('budget_id');
            $table->unsignedBigInteger('type_of_recipe_id');
            $table->integer('quantity')->default(1);
            $table->integer('number')->default(1);
            $table->decimal('amount', 15, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Suppression de la colonne 'type' et réajout des anciennes
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropColumn('type');

            $table->unsignedBigInteger('type_invoice_id')->nullable();
            $table->decimal('amount', 20, 5)->nullable();
            $table->integer('quantity')->nullable();
        });

        // Suppression des tables pivots
        Schema::dropIfExists('budget_type_invoice');
        Schema::dropIfExists('budget_type_of_recipe');
    }
}
