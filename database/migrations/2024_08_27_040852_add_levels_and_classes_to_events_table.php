<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLevelsAndClassesToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('levels')->nullable()->after('idSection');
            $table->string('classes')->nullable()->after('levels');

            $table->dropColumn('idLevel');
            $table->dropColumn('idClasse');
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
            $table->integer('idClasse')->unsigned()->nullable()->after('idSection');
            $table->integer('idLevel')->unsigned()->nullable()->after('idClasse');

            $table->dropColumn('idLevel');
            $table->dropColumn('idClasse');
        });
    }
}
