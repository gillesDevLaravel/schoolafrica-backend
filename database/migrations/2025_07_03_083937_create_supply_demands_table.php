<?php

use App\Enums\SupplyDemandPriorityEnum;
use App\Enums\SupplyDemandStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_demands', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('responsible_id');
            $table->enum('status', SupplyDemandStatusEnum::values())->default(SupplyDemandStatusEnum::PENDING);
            $table->enum('priority', SupplyDemandPriorityEnum::values())->default(SupplyDemandPriorityEnum::LOW);

            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('article_supply_demand', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('article_id');
            $table->unsignedInteger('supply_demand_id');
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedInteger('supplier_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supply_demands');
        Schema::dropIfExists('article_supply_demand');
    }
}
