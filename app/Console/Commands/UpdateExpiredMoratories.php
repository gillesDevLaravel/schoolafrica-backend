<?php

namespace App\Console\Commands;

use App\Enums\MoratoriumStatusEnum;
use App\Enums\StatusEnum;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Moratoire;
use Illuminate\Support\Facades\Log;
use App\Models\Moratorium;
use Google\Service\AIPlatformNotebooks\Status;

class UpdateExpiredMoratories extends Command
{
    /**
     * Nom et signature
     *
     * @var string
     */
    protected $signature = 'moratoire:update-expired';

    /**
     * description de la commande
     *
     * @var string
     */
    protected $description = 'met a jour automatiquement les moratoires expirés';

    /**
     * execute la commande
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute la commande
     * @return int
     */
   public function handle()
{
    $today = Carbon::today();

    $updated = Moratorium::where('status', MoratoriumStatusEnum::VALID)
        ->whereDate('endDate', '<', $today)
        ->update(['status' => MoratoriumStatusEnum::EXPIRED]);
    if ($updated === 0) {
        $this->info('Aucun moratoire expiré trouvé.');
    } else {
        $this->info("Nombre de moratoires mis à jour : {$updated}");
    }

    Log::info("CRON moratoires expirés exécuté à ".now()." - {$updated} moratoires mis à jour");
}

}
