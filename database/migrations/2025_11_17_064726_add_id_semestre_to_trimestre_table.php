<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdSemestreToTrimestreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trimestre', function (Blueprint $table) {
            $table->unsignedInteger('idSemestre')->nullable()->after('idSection');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trimestre', function (Blueprint $table) {
            $table->dropColumn('idSemestre');
        });
    }
}
