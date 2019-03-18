<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WishlistItemBoughtMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $wishlistitem;
    public $mail_subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $wishlistitem, $mail_subject)
    {
        //
        $this->user = $user;
        $this->wishlistitem = $wishlistitem;
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
                    ->view('emails.wishlistitembought');
    }
}
