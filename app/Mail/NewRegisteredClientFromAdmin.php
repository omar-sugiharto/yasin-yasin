<?php

namespace App\Mail;

use App\SiteInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRegisteredClientFromAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $pass;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $pass)
    {
        $this->user = $user;
        $this->pass = $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.newRegisterClientFromAdmin')
                    ->subject('Selamat Datang di KJA Yasin & Yasin')
                    ->from(SiteInfo::search('no_reply_mail', true))
                    ->with([
                        'user' => $this->user,
                        'pass' => $this->pass
                    ]);
    }
}
