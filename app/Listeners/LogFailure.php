<?php

namespace App\Listeners;

use App\Events\ItMadeBoom;
use App\FailureHistory;
use Carbon\Carbon;

class LogFailure
{
    /**
     * Handle the event.
     *
     * @param ItMadeBoom $event
     */
    public function handle(ItMadeBoom $event)
    {
        $history = new FailureHistory([
            'date' => Carbon::now(),
            'message' => $event->failreason,
        ]);
        $history->check()->associate($event->check);
        $history->save();
    }
}
