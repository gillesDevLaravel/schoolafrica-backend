<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerifiedToMobileBuildVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->table('mobile_build_versions', function (Blueprint $table) {
            $table->boolean('verified')
                ->after('build_number')
                ->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('mobile_build_versions', function (Blueprint $table) {
            $table->dropColumn('verified');
        });
    }
}
