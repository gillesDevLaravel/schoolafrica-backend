<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsOnInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('type_produit')->nullable()->after('number');
            $table->double('quantite')->nullable()->after('type_produit');
            $table->string('prix_unitaire')->nullable()->after('quantite');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('type_produit');
            $table->dropColumn('quantite');
            $table->dropColumn('prix_unitaire');
        });
    }
}
