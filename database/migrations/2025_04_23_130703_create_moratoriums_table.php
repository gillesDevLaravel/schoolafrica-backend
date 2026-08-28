<?php

use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoratoriumsTable extends Migration
{
    public function up()
    {
        Schema::create('moratoriums', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('idUser');
            $table->date('startDate');
            $table->date('endDate');
            $table->text('reason')->nullable();
            $table->enum('status', StatusEnum::values())->default(StatusEnum::PENDING_APPROVAL);
            $table->unsignedInteger('idUserApprove');
            $table->unsignedInteger('createdBy');
            $table->unsignedInteger('updatedBy')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('moratoriums');
    }
}
