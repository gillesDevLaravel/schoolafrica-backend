<?php

use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_advances', function (Blueprint $table) {
            $table->id();$table->unsignedInteger('idUser');
            $table->unsignedInteger('idUserApprove');
            $table->float('amount');
            $table->enum('status', StatusEnum::values())->default(StatusEnum::PENDING_APPROVAL);
            $table->text('reason');
            $table->date('approval_date')->nullable();
            $table->text('comments')->nullable();

            $table->boolean('deleted')->default(false);
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_advances');
    }
}
