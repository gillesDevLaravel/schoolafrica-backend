<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetDurationNullableAndStatusDefaultValueOnContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table){
            $table->integer('duration')->nullable()->change();
            $table->string('status')->default('pending_approval')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table){
            $table->integer('duration')->nullable(false)->change();
            $table->string('status')->default(null)->change();
        });
    }
}
