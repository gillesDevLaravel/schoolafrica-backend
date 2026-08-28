<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPourcentageToAssessmentTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessment_type', function (Blueprint $table) {
            
            $table->decimal('pourcentage', 5, 2)->nullable()->after('numbering');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessment_type', function (Blueprint $table) {
            $table->dropColumn('pourcentage');
        });
    }
}
