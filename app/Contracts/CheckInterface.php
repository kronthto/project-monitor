<?php

namespace App\Contracts;

use Carbon\Carbon;

interface CheckInterface
{
    public function getName(): string;

    public function getInterval(): int;

    public function getOffset(): int;

    public function isDueAt(Carbon $time): bool;
}
