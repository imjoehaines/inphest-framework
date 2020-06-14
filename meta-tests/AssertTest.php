<?php

declare(strict_types=1);

namespace Inphest\MetaTests;

use Exception;
use Inphest\Assert;
use TypeError;

final class AssertTest
{
    public function testOneIsOne(Assert $assert): void
    {
        $assert->same(1, 1);
    }

    public function testAbcIsAbc(Assert $assert): void
    {
        $assert->same('abc', 'abc');
    }

    public function testEmptyArrayIsEmptyArray(Assert $assert): void
    {
        $assert->same([], []);
    }

    public function testTrueIsTrue(Assert $assert): void
    {
        $assert->same(true, true);
    }

    public function testFalseIsFalse(Assert $assert): void
    {
        $assert->same(false, false);
    }

    public function testThisIsThis(Assert $assert): void
    {
        $assert->same($this, $this);
    }

    public function testThrowsWithException(Assert $assert): void
    {
        $assert->throws(function (): void {
            throw new Exception('oh no');
        }, new Exception('oh no'));
    }

    public function testThrowsWithTypeError(Assert $assert): void
    {
        $assert->throws(function (): void {
            throw new TypeError('bad');
        }, new TypeError('bad'));
    }
}
