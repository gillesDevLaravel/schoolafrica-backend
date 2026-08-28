<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedToFeeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fee_user', function (Blueprint $table) {
            $table->string('reason')->nullable()->after('photo');
            $table->boolean('deleted')->default(false)->after('reason');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fee_user', function (Blueprint $table) {
            $table->dropColumn('reason');
            $table->dropColumn('deleted');
        });
    }
}
