<?php

namespace Tests\Unit;

use App\Contracts\CheckDueHelper;
use App\Contracts\CheckInterface;
use Carbon\Carbon;
use Tests\TestCase;

class CheckTest extends TestCase
{
    /**
     * Verify that isDueAt works as expected.
     */
    public function testIsDue()
    {
        $check = new CheckConcrete();
        $time = new Carbon();

        $check->interval = 5;
        $time->minute = 0;

        $this->assertTrue($check->isDueAt($time));
        $check->interval = 3;
        $this->assertTrue($check->isDueAt($time));
        $time->minute = 4;
        $this->assertFalse($check->isDueAt($time));
        $time->minute = 6;
        $this->assertTrue($check->isDueAt($time));
        $check->offset = 1;
        $this->assertFalse($check->isDueAt($time));
        $time->minute = 5;
        $this->assertTrue($check->isDueAt($time));
        $time->minute = 0;
        $this->assertFalse($check->isDueAt($time));
    }
}

class CheckConcrete implements CheckInterface
{
    use CheckDueHelper;

    public $interval;
    public $offset = 0;

    public function getName(): string
    {
        return 'name';
    }

    public function getInterval(): int
    {
        return $this->interval;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}
