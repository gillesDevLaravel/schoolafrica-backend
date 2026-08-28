<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToArticleMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_movements', function (Blueprint $table) {
            $table->text("reason")->nullable()->after('quantity');
            $table->dateTimeTz("date")->nullable()->after('reason');
            $table->unsignedInteger("user_id")->nullable()->after('operation_type');
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
            $table->dropColumn(["reason", "date", "user_id",]);
        });
    }
}
