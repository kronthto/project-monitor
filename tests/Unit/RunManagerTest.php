<?php

namespace Tests\Unit;

use App\Contracts\CheckerInterface;
use App\Services\RunManager;
use Tests\TestCase;

class RunManagerTest extends TestCase
{
    /**
     * Assert that checkers can be registered and will be executed (run called).
     */
    public function testCanRegisterThingsToStackThatWillBeCalled()
    {
        /** @var CheckerInterface|\Mockery\MockInterface $checker */
        $checker = \Mockery::mock(CheckerInterface::class);
        $checker->shouldReceive('run')->once();

        $runManager = new RunManager();
        $runManager->register($checker);

        $runManager->processStack();
    }
}
