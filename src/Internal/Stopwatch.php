<?php

declare(strict_types=1);

namespace Inphest\Internal;

use Closure;

final class Stopwatch
{
    public function measure(Closure $callback): int
    {
        $start = hrtime(true);

        $callback();

        $end = hrtime(true);

        return $end - $start;
    }
}
