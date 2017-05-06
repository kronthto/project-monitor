<?php

namespace Tests\Feature;

use App\Contracts\CheckInterface;
use App\Events\ItMadeBoom;
use App\Services\Checkers\AbstractChecker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AbstractCheckerTest extends TestCase
{
    /**
     * A time instance should be kept with the time of the start, not advancing even if checks run longer.
     */
    public function testKeepsATimeInstanceOfStart()
    {
        $time = CheckerConcrete::getTime()->copy()->timestamp;

        sleep(2);

        $this->assertSame($time, CheckerConcrete::getTime()->timestamp);
    }

    /**
     * Assert that the fail event is triggered on check fail.
     */
    public function testFailingSendsANotification()
    {
        $checker = new CheckerConcrete();
        /** @var CheckInterface|\Mockery\MockInterface $check */
        $check = \Mockery::mock(CheckInterface::class);

        Event::fake();

        $checker->failTest($check, 'somereason');

        Event::assertDispatched(ItMadeBoom::class, function (ItMadeBoom $e) use (&$check) {
            return $e->check === $check && $e->failreason == 'somereason';
        });
    }
}

class CheckerConcrete extends AbstractChecker
{
    public static function getTime()
    {
        return static::getNow();
    }

    public function failTest(CheckInterface $check, string $reason)
    {
        $this->checkFailed($check, $reason);
    }

    public function run()
    {
    }
}
