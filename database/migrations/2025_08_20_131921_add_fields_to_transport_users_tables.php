<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTransportUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transport_users', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->after('type');
            $table->boolean('reduction')->nullable()->after('amount');
            $table->decimal('reduction_amount', 10, 2)->nullable()->after('reduction');
            $table->text('reason')->nullable()->after('reduction_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transport_users', function (Blueprint $table) {
            $table->dropColumn(
                ['amount','reduction','reduction_amount','reason',]
            );
        });
    }
}
