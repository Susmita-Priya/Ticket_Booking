<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $resetCode;

    public function __construct(User $user, $resetCode)
    {
        $this->user = $user; 
        $this->resetCode = $resetCode;
    }

    public function build()
    {
        return $this->view('users.passwordReset') // Ensure you have this view
        ->with([
            'user' => $this->user,
            'resetCode' => $this->resetCode,
        ]);
    }
}
