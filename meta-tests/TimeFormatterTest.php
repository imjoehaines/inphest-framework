<?php

declare(strict_types=1);

namespace Inphest\MetaTests;

use Inphest\Assert;
use Inphest\Internal\TimeFormatter;

final class TimeFormatterTest
{
    public function testFormatZero(Assert $assert): void
    {
        $assert->same('0ms', TimeFormatter::format(0));
    }

    public function testFormat1Millisecond(Assert $assert): void
    {
        $assert->same('1ms', TimeFormatter::format(1_000_000));
    }

    public function testFormat99Millisecond(Assert $assert): void
    {
        $assert->same('99ms', TimeFormatter::format(99_000_000));
    }

    public function testFormat999Millisecond(Assert $assert): void
    {
        $assert->same('999ms', TimeFormatter::format(999_000_000));
    }

    public function testFormat1Second(Assert $assert): void
    {
        $assert->same('1s', TimeFormatter::format(1_000_000_000));
    }

    public function testFormat59Seconds(Assert $assert): void
    {
        $assert->same('59s', TimeFormatter::format(59_000_000_000));
    }

    public function testFormat59Seconds99Milliseconds(Assert $assert): void
    {
        $assert->same('59s 99ms', TimeFormatter::format(59_099_000_000));
    }

    public function testFormat59Seconds999Milliseconds(Assert $assert): void
    {
        $assert->same('59s 999ms', TimeFormatter::format(59_999_000_000));
    }

    public function testFormat1Minute(Assert $assert): void
    {
        $assert->same('1m', TimeFormatter::format(60_000_000_000));
    }

    public function testFormat10Minutes(Assert $assert): void
    {
        $assert->same('10m', TimeFormatter::format(600_000_000_000));
    }

    public function testFormat12Minutes34Seconds56Milliseconds(Assert $assert): void
    {
        $assert->same('12m 34s 56ms', TimeFormatter::format(754_056_000_000));
    }

    public function testFormat11Minutes11Seconds999Milliseconds(Assert $assert): void
    {
        $assert->same('11m 11s 999ms', TimeFormatter::format(671_999_000_000));
    }
}
