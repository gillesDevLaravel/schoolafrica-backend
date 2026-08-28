<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumCnpsAndOthersOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('num_cnps')->nullable()->after('observation');
            $table->string('niu')->nullable()->after('num_cnps');
            $table->string('agence')->nullable()->after('niu');
            $table->string('service')->nullable()->after('agence');
            $table->string('categorie')->nullable()->after('service');
            $table->string('num_dipe')->nullable()->after('categorie');
            $table->date('date_embauche')->nullable()->after('num_dipe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('num_cnps');
            $table->dropColumn('niu');
            $table->dropColumn('agence');
            $table->dropColumn('service');
            $table->dropColumn('categorie');
            $table->dropColumn('num_dipe');
            $table->dropColumn('date_embauche');
        });
    }
}
