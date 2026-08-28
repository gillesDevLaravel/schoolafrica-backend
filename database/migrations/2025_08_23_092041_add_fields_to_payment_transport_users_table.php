<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPaymentTransportUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_transport_users', function (Blueprint $table) {
            $table->string('scan_receipt', 125)->nullable()->after('id');
            $table->string('solvable', 125)->nullable(false)->after('payment_mode');
            $table->string('photo', 125)->nullable()->after('solvable');
            $table->string('reason', 125)->nullable()->after('photo');

            $table->string('receipt_number', 125)->nullable()->after('reason');

            $table->string('telephone', 125)->nullable()->after('receipt_number');
            $table->string('reference', 7)->nullable()->after('telephone');

            $table->unsignedInteger('created_by')->nullable()->after('receipt_number');
            $table->unsignedInteger('updated_by')->nullable()->after('created_by');
            $table->unsignedInteger('deleted_by')->nullable()->after('updated_by');
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
            $table->dropColumn([
                'scan_receipt',
                'solvable',
                'photo',
                'reason',
                'receipt_number',
                'telephone',
                'reference',
                'created_by',
                'updated_by',
                'deleted_by',
            ]);
        });
    }
}
