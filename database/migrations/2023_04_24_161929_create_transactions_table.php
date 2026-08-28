<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->longText('access_token');
            $table->bigInteger('expires_in');
            $table->string('order_id')->nullable();
            $table->double('amount')->nullable();
            $table->string('reference')->nullable();
            $table->string('status')->nullable();
            $table->string('message')->nullable();
            $table->string('pay_token')->nullable();
            $table->string('payment_url')->nullable();
            $table->string('notif_token')->nullable();
            $table->string('tnxid')->nullable();

            $table->string('payment_mode')->nullable();
            $table->date('payment_date')->nullable();
            $table->integer('idInvoice')->unsigned()->nullable();
            $table->integer('idFee')->unsigned()->nullable();
            $table->integer('idLevel')->unsigned()->nullable();
            $table->integer('idStudent')->unsigned()->nullable();
            $table->integer('idSchool')->unsigned()->nullable();
            $table->integer('idSection')->unsigned()->nullable();
            $table->integer('idInscription')->unsigned()->nullable();
            $table->integer('idPension')->unsigned()->nullable();
            $table->integer('idTranche')->unsigned()->nullable();
            $table->integer('idEnseignant')->unsigned()->nullable();
            $table->integer('compteEmeteur')->unsigned()->nullable();
            $table->integer('compteRecepteur')->unsigned()->nullable();
            $table->string('type')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            
            $table->foreign('idInvoice')->references('id')->on('invoices')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idSchool')->references('id')->on('schools')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idSection')->references('id')->on('section')->onDelete('restrict')->onUpdate('restrict');            
            $table->foreign('idInscription')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idPension')->references('id')->on('pensions')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idTranche')->references('id')->on('tranches')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('idEnseignant')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
