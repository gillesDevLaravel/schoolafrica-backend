<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeOfRecipeIdToPensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pensions', function (Blueprint $table) {
            $table->unsignedInteger('type_of_recipe_id')->nullable()->after('idSection');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pensions', function (Blueprint $table) {
            $table->dropColumn('type_of_recipe_id');
        });
    }
}
