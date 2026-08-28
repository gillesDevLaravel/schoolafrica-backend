<?php

use App\Enums\WithdrawalTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddTypeToWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->enum('type', WithdrawalTypeEnum::values())->nullable()->after('mode_retrait');
        });


        // ✅ Met à jour les enregistrements existants
        DB::table('withdrawals')
            ->whereNull('type')
            ->update(['type' => WithdrawalTypeEnum::OM]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
