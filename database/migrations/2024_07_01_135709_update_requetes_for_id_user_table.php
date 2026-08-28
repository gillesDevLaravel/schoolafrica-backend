<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequetesForIdUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requetes', function (Blueprint $table) {
            $table->integer('idUser')->unsigned()->after('idTypeRequete');
            $table->dropColumn('idParent');
            $table->dropColumn('idStudent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requetes', function (Blueprint $table) {
            //
        });
    }
}
