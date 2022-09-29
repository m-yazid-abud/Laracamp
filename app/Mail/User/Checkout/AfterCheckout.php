<?php

namespace App\Mail\User\Checkout;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AfterCheckout extends Mailable
{
    use Queueable, SerializesModels;

    private string $username, $campTitle;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $campTitle, string $username)
    {
        $this->campTitle = $campTitle;
        $this->username = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user.after-checkout', [
            "name" => $this->username,
            "campTitle" => $this->campTitle,
        ]);
    }
}
