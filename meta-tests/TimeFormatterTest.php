<?php

declare(strict_types=1);

namespace Inphest\MetaTests;

use Inphest\Assert;
use Inphest\Internal\TimeFormatter;
use function Inphest\test;

test('0 is formatted as "0ms"', function (Assert $assert): void {
    $assert->same('0ms', TimeFormatter::format(0));
});

test('1 millisecond is formatted as "1ms"', function (Assert $assert): void {
    $assert->same('1ms', TimeFormatter::format(1_000_000));
});

test('99 milliseconds is formatted as "99ms"', function (Assert $assert): void {
    $assert->same('99ms', TimeFormatter::format(99_000_000));
});

test('999 milliseconds is formatted as "999ms"', function (Assert $assert): void {
    $assert->same('999ms', TimeFormatter::format(999_000_000));
});

test('1 second is formatted as "1s"', function (Assert $assert): void {
    $assert->same('1s', TimeFormatter::format(1_000_000_000));
});

test('59 seconds is formatted as "59s"', function (Assert $assert): void {
    $assert->same('59s', TimeFormatter::format(59_000_000_000));
});

test('59 seconds & 99 milliseconds is formatted as "59s 99ms"', function (Assert $assert): void {
    $assert->same('59s 99ms', TimeFormatter::format(59_099_000_000));
});

test('59 seconds & 999 milliseconds is formatted as "59s 999ms', function (Assert $assert): void {
    $assert->same('59s 999ms', TimeFormatter::format(59_999_000_000));
});

test('1 minute is formatted as "1m"', function (Assert $assert): void {
    $assert->same('1m', TimeFormatter::format(60_000_000_000));
});

test('10 minutes is formatted as "10m"', function (Assert $assert): void {
    $assert->same('10m', TimeFormatter::format(600_000_000_000));
});

test('12 minutes, 34 seconds & 56 milliseconds is formatted as "12m 34s 56ms"', function (Assert $assert): void {
    $assert->same('12m 34s 56ms', TimeFormatter::format(754_056_000_000));
});

test('11 minutes, 11 seconds & 999 milliseconds is formatted as "11m 11s 999ms"', function (Assert $assert): void {
    $assert->same('11m 11s 999ms', TimeFormatter::format(671_999_000_000));
});
