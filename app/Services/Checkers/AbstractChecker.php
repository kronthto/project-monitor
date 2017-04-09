<?php

namespace App\Services\Checkers;

use App\Contracts\CheckerInterface;
use App\Contracts\CheckInterface;
use App\Events\ItMadeBoom;
use Carbon\Carbon;

abstract class AbstractChecker implements CheckerInterface
{
    /** @var Carbon|null */
    private static $now;

    protected static function getNow(): Carbon
    {
        if (!self::$now) {
            self::$now = new Carbon();
        }

        return self::$now;
    }

    protected function checkFailed(CheckInterface $check, string $reason)
    {
        event(new ItMadeBoom($check, $reason));
    }
}
