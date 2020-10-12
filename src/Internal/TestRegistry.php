<?php

declare(strict_types=1);

namespace Inphest\Internal;

use Closure;

final class TestRegistry
{
    /**
     * @var list<TestCase>
     */
    private static array $tests = [];

    public static function register(string $label, Closure $test): void
    {
        self::$tests[] = new TestCase($label, $test);
    }

    /**
     * @return iterable<int, TestCase>
     */
    public static function iterate(): iterable
    {
        yield from self::$tests;
    }
}
