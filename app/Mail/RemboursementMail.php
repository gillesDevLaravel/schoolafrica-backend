<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class RemboursementMail extends Mailable
{
    use Queueable, SerializesModels;

    public $montant;
    public $mode_retrait;
    public $rib;
    public $numero;
    public $date;
    public $nom;
    public $etablissement;

    /**
     * Create a new message instance.
     */
    public function __construct($montant, $mode_retrait, $rib, $numero, $date, $nom, $etablissement)
    {
        $this->montant = $montant;
        $this->mode_retrait = $mode_retrait;
        $this->rib = $rib;
        $this->numero = $numero;
        $this->date = $date;
        $this->nom = $nom;
        $this->etablissement = $etablissement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('remboursement@ms-school.net', config('app.name'))
                    ->subject('Demande de remboursement')
                    ->markdown('emails.remboursement');
    }
}
