<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->date('payment_deadline')->nullable()->change();

            //

            $table->string('idCustomer')->after("id")->nullable();
            $table->string('image')->after("payment_deadline")->nullable();
            $table->string('date')->after("image");
            $table->enum('statut', ['paid', 'unpaid'])->after("date")->default('paid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('idCustomer');
            $table->dropColumn('image');
            $table->dropColumn('date');
            $table->dropColumn('statut');
        });
    }
}
