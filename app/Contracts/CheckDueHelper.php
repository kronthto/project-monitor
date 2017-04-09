<?php

namespace App\Contracts;

use Carbon\Carbon;

trait CheckDueHelper
{
    public function isDueAt(Carbon $time): bool
    {
        return (bool) ((($time->minute + $this->getOffset()) % $this->getInterval()) === 0);
    }
}
