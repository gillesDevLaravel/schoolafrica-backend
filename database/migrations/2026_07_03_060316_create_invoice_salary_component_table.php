<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceSalaryComponentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Table pivot pour la relation many-to-many (similaire à article_purchase_order)
        Schema::create('invoice_salary_component', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');  // ID de l'invoice
            $table->unsignedBigInteger('salary_component_id');  // ID du composant de salaire
            $table->decimal('coef', 8, 2)->nullable();  // Coefficient du composant
            $table->decimal('base_amount', 10, 2)->default(0);  // Montant de base du composant
            $table->decimal('coef_patronal', 8, 2)->nullable();  // Coefficient patronal du composant
            $table->decimal('base_patronal', 10, 2)->default(0);  // Montant patronal du composant

           
            
            // Index pour optimiser les performances
            $table->index(['invoice_id', 'salary_component_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_salary_component');
    }
}
