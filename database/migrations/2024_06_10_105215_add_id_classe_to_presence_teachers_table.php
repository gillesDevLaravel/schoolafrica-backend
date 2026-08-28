<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdClasseToPresenceTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presence_teacher', function (Blueprint $table) {
            $table->integer("idClasse")->after("idSection")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presence_teacher', function (Blueprint $table) {
            $table->dropColumn('idClasse');
        });
    }
}
