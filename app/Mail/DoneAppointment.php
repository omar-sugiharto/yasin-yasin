<?php

namespace App\Mail;

use App\SiteInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DoneAppointment extends Mailable
{
    use Queueable, SerializesModels;

    public $event;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.doneAppointment')
                    ->subject('Permintaan Audit Telah Selesai')
                    ->from(SiteInfo::search('no_reply_mail', true))
                    ->with(['event' => $this->event]);
    }
}
