<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->softDeletes();
        });
        //ajoute la colonne deleted_by
        Schema::table('events', function (Blueprint $table) {
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        //supprime la colonne deleted_by
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('deleted_by');
        });
    }
}
