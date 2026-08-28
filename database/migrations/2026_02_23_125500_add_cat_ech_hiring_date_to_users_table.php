<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCatEchHiringDateToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cat')->nullable()->after('matricule');
            $table->string('ech')->nullable()->after('cat');
            $table->date('hiring_date')->nullable()->after('birthday');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cat', 'ech', 'hiring_date']);
        });
    }
};
