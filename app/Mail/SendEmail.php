<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

     public function __construct($jenis_pelayanan, $deskripsi_pengajuan)
    {
        $this->jenis_pelayanan = $jenis_pelayanan;
        $this->deskripsi_pengajuan = $deskripsi_pengajuan;
        $user = Auth::user();
        $this->role = implode(', ', $user->getRoleNames()->toArray());
    }
   

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if ($this->role != 'staff'){
        return (new Envelope())
        ->subject('Pengajuan anda telah berubah')
        ->from('Freatria@gmail.com', 'ATMI Corporation');
            

        }else{

        return (new Envelope())
        ->subject('Anda mempunyai data yang perlu di approve')
        ->from('Freatria@gmail.com', 'ATMI Corporation');
        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
{
   
    $jenis  = $this->jenis_pelayanan;
    $deskripsi = $this->deskripsi_pengajuan;
    return (new Content())
        ->view('email')
        ->with(['role' => $this->role, 'jenis' => $jenis, 'deskripsi' => $deskripsi ]);
}

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

  
    
}
