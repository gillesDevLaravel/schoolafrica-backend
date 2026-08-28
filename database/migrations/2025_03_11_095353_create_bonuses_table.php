<?php

use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('idUser');
            $table->unsignedInteger('idUserApprove');
            $table->enum('bonus_type', ['student', 'staff']);
            $table->float('amount');
            $table->enum('status', StatusEnum::values())->default(StatusEnum::PENDING_APPROVAL);
            $table->text('reason');
            $table->boolean('is_used')->default(false);

            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('bonuses');
    }
}
