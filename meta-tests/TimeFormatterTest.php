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
        '0ms' => ['0ms', 0],
        '1ms' => ['1ms', 1_000_000],
        '99ms' => ['99ms', 99_000_000],
        '999ms' => ['999ms', 999_000_000],
        '1s' => ['1s', 1_000_000_000],
        '59s' => ['59s', 59_000_000_000],
        '59s 99ms' => ['59s 99ms', 59_099_000_000],
        '59s 999ms' => ['59s 999ms', 59_999_000_000],
        '1m' => ['1m', 60_000_000_000],
        '10m' => ['10m', 600_000_000_000],
        '12m 34s 56ms' => ['12m 34s 56ms', 754_056_000_000],
        '11m 11s 999ms' => ['11m 11s 999ms', 671_999_000_000],
    ]
);
