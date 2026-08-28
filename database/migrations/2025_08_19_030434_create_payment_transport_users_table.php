<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransportUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transport_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('transport_id');
            $table->unsignedInteger('student_id');
            $table->decimal('advance_payment', 10, 2)->default(0);
            $table->decimal('balance_payment', 10, 2)->default(0);
            $table->date('payment_date');
            $table->string('payment_mode');
            $table->softDeletes();
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
        Schema::dropIfExists('payment_transport_users');
    }
}
