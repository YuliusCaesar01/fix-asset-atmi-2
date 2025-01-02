<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyUser extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $emailType;
    public $permintaan;

    public function __construct($subject, $emailType, $permintaan)
    {
        $this->subject = $subject;
        $this->emailType = $emailType;
        $this->permintaan = $permintaan;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('email.notifyusers')
                    ->with([
                        'emailType' => $this->emailType,
                        'permintaan' => $this->permintaan,
                    ]);
    }
}
