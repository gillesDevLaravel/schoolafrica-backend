<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_ins', function (Blueprint $table) {
            $table->id();
            $table->integer('idClient')->unsigned();
            $table->string('amount_to_receive');
            $table->string('amount_received');
//            $table->string('remaining_balance');
            $table->string('reason');
            $table->string('payment_method');
            $table->date('payment_date');
            $table->boolean('irpp');
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted')->default(0);
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_ins');
    }
}
