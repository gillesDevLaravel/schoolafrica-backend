<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdProjectToTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer("duree_mise")->after('status')->nullable(); // temps mis sur la tâche... en minutes
            $table->integer("estimation")->after('duree_mise'); // estimation du temps à mettre sur la tâche ... en minutes
            $table->string("observation")->after('estimation')->nullable();
            $table->integer("idProject")->after('observation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn("duree_mise");
            $table->dropColumn("estimation");
            $table->dropColumn("observation");
            $table->dropColumn("idProject");
        });
    }
}
