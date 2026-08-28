<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AjoutDuChampReferenceDansLaTablePensionUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pension_users', function (Blueprint $table) {
            $table->string('reference', 7)->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pension_users', function (Blueprint $table) {
            $table->dropColumn('reference'); 
        });
    }
}
