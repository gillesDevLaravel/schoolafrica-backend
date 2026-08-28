<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdBookOnHomeworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('homework', function (Blueprint $table) {
            $table->integer('idBook')->unsigned()->nullable()->after('idTeacher');
            $table->boolean('deleted')->default(false);
            $table->integer('deleted_by')->nullable(); // celui qui a supprimé#archivé le règlement intérieur
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('homework', function (Blueprint $table) {
            $table->dropColumn('idBook');
            $table->dropColumn('deleted');
            $table->dropColumn('deleted_by');
        });
    }
}
