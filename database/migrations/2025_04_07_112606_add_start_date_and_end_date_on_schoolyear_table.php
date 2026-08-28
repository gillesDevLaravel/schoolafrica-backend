<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddStartDateAndEndDateOnSchoolyearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        DB::table('schoolyears')->truncate();
//
//        Schema::table('schoolyears', function (Blueprint $table) {
//            $table->date('start_date')->after('name');
//            $table->date('end_date')->after('start_date');
//            $table->boolean('deleted')->default(false)->after('end_date');
//            $table->integer('deleted_by')->nullable()->after('deleted');
//
//            $table->dropColumn('idEstablishment');
//        });

        // On ajoute l'année actuelle par défaut
//        DB::table('schoolyears')->insert([
//            'name' => "2024 - 2025",
//            'start_date' => "2024-09-01",
//            'end_date' => "2025-07-31",
//            'created_by' => 1,
//            'created_at' => date("Y-m-d H:i:s"),
//            'updated_at' => date("Y-m-d H:i:s"),
//        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('schoolyears', function (Blueprint $table) {
//            $table->dropColumn('start_date');
//            $table->dropColumn('end_date');
//            $table->dropColumn('deleted');
//            $table->dropColumn('deleted_by');
//
//            $table->integer('idEstablishment')->unsigned()->nullable();
//        });
    }
}
