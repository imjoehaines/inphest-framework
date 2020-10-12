<?php

declare(strict_types=1);

namespace Inphest\Internal;

use Closure;
use Inphest\Assert;
use Inphest\PublicTestCase;

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
     * @return PublicTestCase
     */
    public static function register(string $label, Closure $test): PublicTestCase
    {
        if (!isset(self::$tests[self::$file])) {
            self::$tests[self::$file] = [];
        }

        $testCase = new TestCase($label, $test);

        self::$tests[self::$file][] = $testCase;

        return $testCase;
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
