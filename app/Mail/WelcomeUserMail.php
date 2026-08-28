<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeUserMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $schoolname;
    protected $name;
    protected $username;
    protected $password;
    protected $key;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($school, $user, $key, $password)
    {
        $this->schoolname = $school['name'] ?? "";
        $this->name = $user['name'] ?? "";
        $this->username = $user['username'] ?? "";
        $this->password = $password ?? "";
        $this->key = $key;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome-email-with-access')
            ->with([
                'schoolname' => $this->schoolname,
                'cle' => $this->key,
                'name' => $this->name,
                'username' => $this->username,
                'password' => $this->password,
            ]);
    }
}
