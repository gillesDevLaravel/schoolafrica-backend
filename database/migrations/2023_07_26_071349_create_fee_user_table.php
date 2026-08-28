<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_user', function (Blueprint $table) {
            $table->id();
            $table->integer('idStudent')->unsigned();
            $table->integer('idSchool')->unsigned();
            $table->integer('idSection')->unsigned();
            $table->integer('idFee')->unsigned();
            $table->float('advancePayment');
            $table->float('balancePayment');
            $table->string('payment_mode');
            $table->string('solvable');
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('idStudent')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idSchool')->references('id')->on('schools')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idSection')->references('id')->on('section')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idFee')->references('id')->on('fees')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_user');
    }
}
