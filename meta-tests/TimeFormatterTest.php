<?php

declare(strict_types=1);

namespace Inphest\MetaTests;

use Inphest\Assert;
use Inphest\Internal\TimeFormatter;
use function Inphest\test;

test(
    'times are formatted correctly',
    static function (Assert $assert, string $expected, int $nanoseconds): void {
        $assert->same($expected, TimeFormatter::format($nanoseconds));
    },
    [
        '0.000ms' => ['0.000ms', 0],
        '0.001ms' => ['0.001ms', 1_000],
        '0.101ms' => ['0.101ms', 101_000],
        '1.000ms' => ['1.000ms', 1_000_000],
        '1.111ms' => ['1.111ms', 1_111_000],
        '99.000ms' => ['99.000ms', 99_000_000],
        '999.000ms' => ['999.000ms', 999_000_000],
        '999.123ms' => ['999.123ms', 999_123_000],
        '1s' => ['1s', 1_000_000_000],
        '59s' => ['59s', 59_000_000_000],
        '59s 99.000ms' => ['59s 99.000ms', 59_099_000_000],
        '59s 999.000ms' => ['59s 999.000ms', 59_999_000_000],
        '1m' => ['1m', 60_000_000_000],
        '10m' => ['10m', 600_000_000_000],
        '12m 34s 56.000ms' => ['12m 34s 56.000ms', 754_056_000_000],
        '11m 11s 999.000ms' => ['11m 11s 999.000ms', 671_999_000_000],
        '11m 11s 999.050ms' => ['11m 11s 999.050ms', 671_999_050_000],
        '11m 11s 999.555ms' => ['11m 11s 999.555ms', 671_999_555_000],
    ]
);
