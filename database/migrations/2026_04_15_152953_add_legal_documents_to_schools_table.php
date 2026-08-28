<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLegalDocumentsToSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            // Champs images
            $table->string('land_title')->nullable()->after('logo');
            $table->string('building_permit')->nullable()->after('land_title');
            $table->string('creation_authorization')->nullable()->after('building_permit');
            $table->string('opening_authorization')->nullable()->after('creation_authorization');
            
            // Champs documents/textes
            $table->string('nui')->nullable()->after('opening_authorization');
            $table->string('cnps')->nullable()->after('nui');
            $table->string('location_plan')->nullable()->after('cnps');
            $table->text('information_sheets')->nullable()->after('location_plan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn([
                'land_title',
                'building_permit',
                'creation_authorization',
                'opening_authorization',
                'nui',
                'cnps',
                'location_plan',
                'information_sheets'
            ]);
        });
    }
}
