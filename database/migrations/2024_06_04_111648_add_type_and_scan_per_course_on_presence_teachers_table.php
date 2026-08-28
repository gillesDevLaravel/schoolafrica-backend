<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeAndScanPerCourseOnPresenceTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presence_teacher', function (Blueprint $table) {
            $table->enum('type', ['staff', 'teacher'])->after('idSection')->default('teacher');
            $table->boolean('scanPerCourse')->after('type');
            $table->string("raison")->nullable()->after('scanPerCourse');
            $table->enum("savingType", ['manuel', 'qr'])->default('manuel')->after("raison");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presence_teacher', function (Blueprint $table) {
            //
        });
    }
}
