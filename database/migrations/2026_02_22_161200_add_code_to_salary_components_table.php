<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeToSalaryComponentsTable extends Migration
{
    public function up()
    {
        Schema::table('salary_components', function (Blueprint $table) {
            $table->string('code')->nullable()->after('type');
        });
    }

    public function down()
    {
        Schema::table('salary_components', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
}
