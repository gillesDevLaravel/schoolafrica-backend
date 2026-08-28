<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeAndImageToReglementInterieursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reglement_interieurs', function (Blueprint $table) {
            $table->string('type')->after('description');
            $table->string('image')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reglement_interieurs', function (Blueprint $table) {
            $table->dropColumn(['type', 'image']);
        });
    }
}
