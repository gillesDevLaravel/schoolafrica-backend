<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToTypeInvoicesTable extends Migration
{
    public function up()
    {
        Schema::table('type_invoices', function (Blueprint $table) {
            $table->string('type')->nullable()->after('code');
        });
    }

    public function down()
    {
        Schema::table('type_invoices', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
