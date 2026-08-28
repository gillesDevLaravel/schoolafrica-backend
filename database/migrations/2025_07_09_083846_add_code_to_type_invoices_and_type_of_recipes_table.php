<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeToTypeInvoicesAndTypeOfRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('type_invoices', function (Blueprint $table) {
            $table->string('code')->nullable()->after('name');
        });
        Schema::table('type_of_recipes', function (Blueprint $table) {
            $table->string('code')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type_invoices', function (Blueprint $table) {
            $table->dropColumn('code');
        });
        Schema::table('type_of_recipes', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
}
