<?php

namespace App\Mail;

use App\SiteInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientSendDocuments extends Mailable
{
    use Queueable, SerializesModels;

    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.clientSendDocuments')
                    ->subject('Pembaruan Dokumen '.$this->name)
                    ->from(SiteInfo::search('no_reply_mail', true))
                    ->with([
                        'name' => $this->name
                    ]);
    }
}
