<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOperationTypeTypeToArticleMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_movements', function (Blueprint $table) {
            $table->dropColumn('operation_type');
        });

        Schema::table('article_movements', function (Blueprint $table) {
            $table->string('operation_type')->after('id'); // adapte la position si besoin
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_movements', function (Blueprint $table) {
            $table->dropColumn('operation_type');
        });

        Schema::table('article_movements', function (Blueprint $table) {
            $table->enum('operation_type', ['entry', 'exit'])->after('id');
        });
    }
}
