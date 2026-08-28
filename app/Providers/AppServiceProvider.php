<?php

namespace App\Providers;

use App\Models\Withdrawal;
use App\Traits\ManageDirectoryTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    use ManageDirectoryTrait;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this -> app -> bind('path.public', function()
        {
                return base_path('public_html');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->createDirectory('pdfs'); // On va mettre ça ici pour que ça crée direct le dossier si il n'existe pas

        Schema::defaultStringLength(125);

        // Vérifie si la table 'withdrawals' existe
        if (Schema::hasTable('withdrawals')) {
            $yesterday_this_time = now()->subDay();

            $expiredWithdrawals = Withdrawal::where('status', 'initiated')
                ->where('updated_at', '<', $yesterday_this_time)
                ->get();

            foreach ($expiredWithdrawals as $withdrawal) {
                $withdrawal->status = 'failed';
                $withdrawal->save();

                Log::warning("CRON--- Retrait expiré passé à 'failed'. idWithdrawal:".$withdrawal->id);
            }
        }

//        $yesterday_this_time = now()->subDay();
//
//        $expiredWithdrawals = Withdrawal::where('status', 'initiated')
//            ->where('updated_at', '<', $yesterday_this_time)
//            ->get();
//
//        foreach ($expiredWithdrawals as $withdrawal) {
//            $withdrawal->status = 'failed';
//            $withdrawal->save();
//
//            Log::warning("CRON--- Retrait expiré passé à 'failed'. idWithdrawal:".$withdrawal->id);
//        }
    }
}
