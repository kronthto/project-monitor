<?php

namespace App\Listeners;

use App\Events\ItMadeBoom;
use App\Notifications\PanicNotification;
use App\TelegramRecipient;

class SendPanicNotification
{
    /**
     * Handle the event.
     *
     * @param ItMadeBoom $event
     */
    public function handle(ItMadeBoom $event)
    {
        \Notification::sendNow(TelegramRecipient::all(), new PanicNotification($event->check, $event->failreason));
    }
}
