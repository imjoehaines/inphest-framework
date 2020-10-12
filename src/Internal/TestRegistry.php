<?php

declare(strict_types=1);

namespace Inphest\Internal;

use Closure;

final class TestRegistry
{
    /**
     * @var array<string, list<TestCase>>
     */
    private static array $tests = [];
    private static string $file;

    public static function register(string $label, Closure $test): void
    {
        if (!isset(self::$tests[self::$file])) {
            self::$tests[self::$file] = [];
        }

        self::$tests[self::$file][] = new TestCase($label, $test);
    }

    /**
     * @return iterable<string, list<TestCase>>
     */
    public static function iterate(): iterable
    {
        yield from self::$tests;
    }

    public static function setFile(string $file): void
    {
        self::$file = $file;
    }

    public static function isEmpty(): bool
    {
        return self::$tests === [];
    }
}
