<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class ConfirmationWithdrawalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $montant, $mode_retrait, $rib, $numero, $date, $nom, $etablissement, $code;

    /**
     * Create a new message instance.
     */
    public function __construct($montant, $mode_retrait,$rib,$numero,$date, $nom, $etablissement, $code)
    {
        $this->montant = $montant;
        $this->mode_retrait = $mode_retrait;
        $this->rib = $rib;
        $this->numero = $numero;
        $this->date = $date;
        $this->nom = $nom;
        $this->etablissement = $etablissement;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    
    public function build()
    {
        return $this->subject('Code confirmation demande retrait')
                    ->markdown('emails.confirmationretrait');
    }

    
}
