<?php

namespace App\Listeners;

use App\Events\SendEmail;
use App\Mail\EmailSender;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendEmail  $event
     * @return void
     */
    public function handle(SendEmail $event)
    {
        Mail::to($event->receiver)->send(new EmailSender($event->subject, $event->body));
    }
}
