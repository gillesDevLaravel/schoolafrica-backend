<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraCashins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_cashins', function (Blueprint $table) {
            $table->id();
            $table->integer('idClient')->unsigned();
            $table->string('amount_to_receive')->nullable();
            $table->string('amount_received')->nullable();
            $table->text('reason');
            $table->string('payment_method');
            $table->date('payment_date');
            $table->string('receipt_number')->nullable();
            $table->string('operator')->nullable();
            $table->unsignedInteger('type_of_recipe_id')->nullable();
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
        Schema::dropIfExists('extra_cashins');
    }
}
