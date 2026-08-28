<?php

namespace App\Mail;

use App\Models\Classes;
use App\Models\School;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentInitiatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $school;
    public $student;
    public $classe;
    public $number;
    public $amount;
    public $idTransaction;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($school, $student, $classe, $number, $amount, $idTransaction)
    {
        $user = User::select('name', 'idClasse')->findOrFail($student);

        $this->school = School::select('name')->findOrFail($school)->name;
        $this->student = $user->name;
        $this->classe = Classes::findOrFail($user->idClasse)->name;
        $this->number = $number;
        $this->amount = $amount;
        $this->idTransaction = $idTransaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('remboursement@ms-school.net', config('app.name'))
            ->subject('Paiement initié')
            ->markdown('emails.payment_initiated');
    }
}
