<?php

use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdUserApproveAndStatusFieldsToSalaryDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_deductions', function (Blueprint $table) {
            $table->unsignedInteger('idUserApprove')->after("idUser");
            $table->enum("status", StatusEnum::values())->default(StatusEnum::PENDING_APPROVAL)->after("date");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_deductions', function (Blueprint $table) {
            $table->dropColumn('idUserApprove');
            $table->dropColumn("status");
        });
    }
}
