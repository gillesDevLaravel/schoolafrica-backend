<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionAndDateOnNoteFraisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('note_frais', function (Blueprint $table) {
            $table->longText('description')->nullable()->after('status');
            $table->date('date')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('note_frais', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('date');
        });
    }
}
