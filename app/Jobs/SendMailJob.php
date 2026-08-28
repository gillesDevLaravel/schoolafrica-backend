<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

/**
 * Ton role est simple, tu récupère le Mail qu'on envoie et c'est toi qui le balance...
 * Facile nor ?
 */

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mailable;
    protected $recipients;
    protected $smtp;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Mailable $mailable, $recipients, $smtp = null)
    {
        $this->mailable = $mailable;
        $this->recipients = is_array($recipients) ? $recipients : [$recipients];
        $this->smtp = $smtp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::mailer($this->smtp)->to($this->recipients)->send($this->mailable);
    }
}
