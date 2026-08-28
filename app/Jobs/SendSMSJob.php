<?php

namespace App\Jobs;

use App\Traits\SMSTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Le but de ce gars est qu'il soit appelé CHAQUE FOIS qu'on voudra envoyer un SMS.
 * Donc on n'appelle JAMAIS SMSTrait::sendSMS directement
 */

class SendSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    use Queueable;
    use SMSTrait;

    public $mobiles; // array
    public $message;
    public $accountName;

    /**
     * Create a new job instance.
     */
    public function __construct(array $mobiles, $message, $accountName = null)
    {
        $this->mobiles = $mobiles;
        $this->message = $message;
        $this->accountName = $accountName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->sendSMS($this->mobiles, $this->message, $this->accountName);
    }
}
