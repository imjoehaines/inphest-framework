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

        if ($minutes > 0) {
            $string .= "{$minutes}m ";
        }

        if ($seconds > 0) {
            $string .= "{$seconds}s ";
        }

        if ($milliseconds > 0 || $string === '') {
            $microseconds = intdiv($nanoseconds, 1_000) % 1_000;

            $string .= sprintf('%d.%03dms', $milliseconds, $microseconds);
        }

        return rtrim($string, ' ');
    }
}
