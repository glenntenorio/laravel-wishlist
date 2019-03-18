<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WishlistItemsBoughtMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $wishlistitems;
    public $mail_subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $wishlistitems, $mail_subject)
    {
        //
        $this->user = $user;
        $this->wishlistitems = $wishlistitems;
        $this->mail_subject = $mail_subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mail_subject)
                    ->view('emails.wishlistitemsbought');
    }
}
