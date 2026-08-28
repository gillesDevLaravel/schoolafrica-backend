<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuteurOnBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('auteur')->nullable()->after('status');
            $table->string('editeur')->nullable()->after('auteur');
            $table->string('date_publication')->nullable()->after('editeur');
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
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('auteur');
            $table->dropColumn('editeur');
            $table->dropColumn('date_publication');
            $table->dropColumn('deleted');
            $table->dropColumn('deleted_by');
        });
    }
}
