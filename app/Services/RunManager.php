<?php

namespace App\Services;

use App\Contracts\CheckerInterface;

class RunManager
{
    /** @var array|CheckerInterface[] */
    protected $checkers = [];

    public function register(CheckerInterface $checker)
    {
        $this->checkers[] = $checker;
    }

    public function processStack()
    {
        foreach ($this->checkers as $checker) {
            $checker->run();
        }
    }
}
