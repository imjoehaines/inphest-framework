<?php

declare(strict_types=1);

namespace Inphest\MetaTests;

use Inphest\Assert;
use Inphest\Internal\TimeFormatter;
use function Inphest\test;

test('FormatZero', function (Assert $assert): void {
    $assert->same('0ms', TimeFormatter::format(0));
});

test('Format1Millisecond', function (Assert $assert): void {
    $assert->same('1ms', TimeFormatter::format(1_000_000));
});

test('Format99Millisecond', function (Assert $assert): void {
    $assert->same('99ms', TimeFormatter::format(99_000_000));
});

test('Format999Millisecond', function (Assert $assert): void {
    $assert->same('999ms', TimeFormatter::format(999_000_000));
});

test('Format1Second', function (Assert $assert): void {
    $assert->same('1s', TimeFormatter::format(1_000_000_000));
});

test('Format59Seconds', function (Assert $assert): void {
    $assert->same('59s', TimeFormatter::format(59_000_000_000));
});

test('Format59Seconds99Milliseconds', function (Assert $assert): void {
    $assert->same('59s 99ms', TimeFormatter::format(59_099_000_000));
});

test('Format59Seconds999Milliseconds', function (Assert $assert): void {
    $assert->same('59s 999ms', TimeFormatter::format(59_999_000_000));
});

test('Format1Minute', function (Assert $assert): void {
    $assert->same('1m', TimeFormatter::format(60_000_000_000));
});

test('Format10Minutes', function (Assert $assert): void {
    $assert->same('10m', TimeFormatter::format(600_000_000_000));
});

test('Format12Minutes34Seconds56Milliseconds', function (Assert $assert): void {
    $assert->same('12m 34s 56ms', TimeFormatter::format(754_056_000_000));
});

test('Format11Minutes11Seconds999Milliseconds', function (Assert $assert): void {
    $assert->same('11m 11s 999ms', TimeFormatter::format(671_999_000_000));
});
