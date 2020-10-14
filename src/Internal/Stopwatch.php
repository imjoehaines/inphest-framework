<?php

declare(strict_types=1);

namespace Inphest\Internal;

final class Stopwatch
{
    private int $start;

    private function __construct(int $start)
    {
        $this->start = $start;
    }

    public static function start(): Stopwatch
    {
        return new Stopwatch(hrtime(true));
    }

    public function lap(): int
    {
        return hrtime(true) - $this->start;
    }
}
