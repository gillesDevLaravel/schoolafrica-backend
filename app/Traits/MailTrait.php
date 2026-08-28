<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

trait MailTrait{
    /**
     * Simple fonction pour l'envoi d'emails
     *
     * @param $receiver
     * @param $view
     * @param $data
     * @param $subject
     */
    public static function sendMail($receiver, $school_name, $view, $data, $subject, $replyTo = null){
        Mail::send($view, $data, function($m) use ($receiver, $school_name, $subject, $replyTo){
            $m->from("support@ms-school.net", "$school_name - MS-SCHOOL");

            $m->to($receiver)->subject($subject);

            if(!is_null($replyTo)) $m->replyTo($replyTo);
        });

        Log::info("Envoi d'email à $receiver à propos de : $subject");
    }
}
