<?php

declare(strict_types=1);

namespace Inphest\Internal;

final class TimeFormatter
{
    public static function format(int $nanoseconds): string
    {
        $minutes = intdiv($nanoseconds, 60_000_000_000);
        $seconds = intdiv($nanoseconds, 1_000_000_000) % 60;
        $milliseconds = intdiv($nanoseconds, 1_000_000) % 1_000;

        $string = '';

        if ($minutes >= 1) {
            $string .= sprintf('%dm ', $minutes);
        }

        if ($seconds >= 1) {
            $string .= sprintf('%ds ', $seconds);
        }

        if ($milliseconds > 0 || $string === '') {
            $string .= sprintf('%dms', $milliseconds);
        }

        return rtrim($string, ' ');
    }
}
