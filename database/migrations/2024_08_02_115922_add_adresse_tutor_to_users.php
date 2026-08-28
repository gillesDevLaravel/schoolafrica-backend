<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdresseTutorToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('adresse_2')->nullable()->after('gender');
            $table->string('adresse_tutor')->nullable()->after("adresse_2");
            $table->string('gender_2')->nullable()->after("adresse_tutor");
            $table->string('gender_tutor')->nullable()->after("gender_2");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
