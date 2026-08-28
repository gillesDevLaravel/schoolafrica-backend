<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFieldsToPaymentTransportUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_transport_users', function (Blueprint $table) {
            $table->dropColumn(['transport_id','student_id',]);
            $table->unsignedInteger('transport_user_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_transport_users', function (Blueprint $table) {
            $table->unsignedInteger('transport_id')->after('id');
            $table->unsignedInteger('student_id')->after('transport_id');
            $table->dropColumn(['transport_user_id']);
        });
    }
}
