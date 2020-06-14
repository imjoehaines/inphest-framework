<?php

declare(strict_types=1);

namespace Inphest\Internal;

use Closure;

final class Stopwatch
{
    public function measure(Closure $callback): float
    {
        $start = hrtime(true);

        $callback();

        $end = hrtime(true);

        return round((float) ($end - $start) / 1e9, 2);
    }
}
