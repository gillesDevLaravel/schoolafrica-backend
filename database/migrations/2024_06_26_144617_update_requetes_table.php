<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requetes', function (Blueprint $table) {
            $table->integer('idTypeRequete')->unsigned()->after('reponse');
            $table->dropColumn('type');

            $table->enum('categorie', ['interne', 'externe'])->after('id');
            $table->dropColumn('libelle');
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
            $table->dropColumn('idTypeRequete');
            $table->string("type")->after('description');

            $table->dropColumn('categorie');
            $table->string("libelle")->after('id');
        });
    }
}
