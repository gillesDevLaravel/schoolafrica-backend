<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderToSalaryComponentsTable extends Migration
{
    public function up()
    {
        Schema::table('salary_components', function (Blueprint $table) {
            $table->integer('order')->default(0)->after('type');
        });
    }

    public function down()
    {
        Schema::table('salary_components', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
