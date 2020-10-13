<?php

declare(strict_types=1);

namespace Inphest\Internal;

use Closure;
use Inphest\Assert;

final class TestRegistry
{
    /**
     * @var array<string, list<TestCase>>
     */
    private static array $tests = [];
    private static string $file;

    /**
     * @param string $label
     * @param Closure(Assert, mixed...): void $test
     * @param array<array-key, array<array-key, mixed>> $data
     * @return void
     */
    public static function register(string $label, Closure $test, array $data): void
    {
        if (!isset(self::$tests[self::$file])) {
            self::$tests[self::$file] = [];
        }

        if ($data === []) {
            self::$tests[self::$file][] = new TestCase($label, $test, []);

            return;
        }

        foreach ($data as $index => $arguments) {
            self::$tests[self::$file][] = new TestCase(
                "{$label} ({$index})",
                $test,
                $arguments
            );
        }
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
