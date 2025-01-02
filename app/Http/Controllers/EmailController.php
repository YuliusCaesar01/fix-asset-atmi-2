<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail()
    {
        $details = [
            'title' => 'Welcome!',
            'body' => 'We are excited to have you get started. First, you need to confirm your account. Just press the button below.'
        ];

        Mail::send('email.email2', $details, function($message) {
            $message->to('danieldeniss92@gmail.com') // Replace with the actual recipient's email
                    ->subject('Confirm Your Account');
        });

        return "Email sent successfully!";
    }
}