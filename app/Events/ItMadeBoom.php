<?php

namespace App\Events;

use App\Contracts\CheckInterface;
use Illuminate\Foundation\Events\Dispatchable;

class ItMadeBoom
{
    use Dispatchable;

    /** @var CheckInterface */
    public $check;
    /** @var string */
    public $failreason;

    /**
     * Create a new event instance.
     *
     * @param CheckInterface $check
     * @param string         $reason
     */
    public function __construct(CheckInterface $check, string $reason)
    {
        $this->check = $check;
        $this->failreason = $reason;
    }
}
