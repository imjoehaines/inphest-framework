<?php

declare(strict_types=1);

namespace Inphest\Assertions\Tests;

use ArithmeticError;
use Exception;
use Inphest\Assertions\Assert;
use Inphest\Assertions\AssertionException;
use InvalidArgumentException;

use PHPUnit\Framework\TestCase;
use stdClass;
use Throwable;

final class AssertTest extends TestCase
{
    /**
     * @dataProvider strictEqualProvider
     *
     * @param mixed $expected
     * @param mixed $actual
     */
    public function testSamePassesForStrictlyEqualValues($expected, $actual): void
    {
        $assert = new Assert();
        $assert->same($expected, $actual);

        $this->assertSame($expected, $actual);
    }

    /**
     * @dataProvider equalProvider
     * @dataProvider notEqualProvider
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     */
    public function testSameFailsForValuesNotStrictlyEqual($expected, $actual, string $message): void
    {
        $this->expectExceptionObject(new AssertionException($message));

        $assert = new Assert();
        $assert->same($expected, $actual);
    }

    /**
     * @dataProvider throwingCallbackProvider
     */
    public function testThrowsPassesWhenCallableThrowsTheCorrectException(
        callable $callback,
        Throwable $expected
    ): void {
        $assert = new Assert();
        $assert->throws($callback, $expected);

        $this->expectException(get_class($expected));
        $this->expectExceptionMessage($expected->getMessage());
        $this->expectExceptionCode($expected->getCode());
        $callback();
    }

    public function testThrowsFailsForCallbacksThatDoNotThrow(): void
    {
        $this->expectExceptionObject(
            new AssertionException('Given callable did not throw (expecting "Exception (0)" — "boop")')
        );

        $assert = new Assert();
        $assert->throws(function (): void {
            // noop
        }, new Exception('boop'));
    }

    public function testThrowsFailsForExceptionsWithIncorrectMessages(): void
    {
        $this->expectExceptionObject(
            new AssertionException('"Not the right message" does not match expected message "A message"')
        );

        $assert = new Assert();
        $assert->throws(
            function (): void {
                throw new Exception('Not the right message');
            },
            new Exception('A message')
        );
    }

    /**
     * @psalm-return iterable<array-key, array{mixed, mixed}>
     */
    public function strictEqualProvider(): iterable
    {
        $instance = new stdClass();

        return [
            [true, true],
            [false, false],
            [1, 1],
            [0, 0],
            ['1', '1'],
            ['abc', 'abc'],
            [null, null],
            [1.1, 1.1],
            [[], []],
            [[1], [1]],
            [['a'], ['a']],
            [$instance, $instance],
        ];
    }

    /**
     * @psalm-return iterable<array-key, array{mixed, mixed, string}>
     */
    public function equalProvider(): iterable
    {
        return [
            [true, 1, 'true is not the same as 1'],
            [false, 0, 'false is not the same as 0'],
            [1, '1', '1 is not the same as "1"'],
            [999, '999', '999 is not the same as "999"'],
            [2.2, '2.2', '2.2 is not the same as "2.2"'],
            [[], false, '[] is not the same as false'],
            [[], null, '[] is not the same as null'],
            [false, null, 'false is not the same as null'],
            [0, null, '0 is not the same as null'],
            [new stdClass(), new stdClass(), '{} is not the same as {}'],
        ];
    }

    /**
     * @psalm-return iterable<array-key, array{mixed, mixed, string}>
     */
    public function notEqualProvider(): iterable
    {
        return [
            [true, 0, 'true is not the same as 0'],
            [false, 1, 'false is not the same as 1'],
            [1, '12', '1 is not the same as "12"'],
            [999, '888', '999 is not the same as "888"'],
            [2.2, 3.3, '2.2 is not the same as 3.3'],
            [[], [2], '[] is not the same as [2]'],
            [null, true, 'null is not the same as true'],
        ];
    }

    /**
     * @psalm-return iterable<array-key, array{callable, Throwable}>
     */
    public function throwingCallbackProvider(): iterable
    {
        return [
            [
                fn () => $this->throwingCallable(),
                new Exception('throwingCallable message'),
            ],
            [
                function (): void {
                    throw new Exception('Exception message');
                },
                new Exception('Exception message'),
            ],
            [
                function (): void {
                    throw new InvalidArgumentException('InvalidArgumentException message');
                },
                new InvalidArgumentException('InvalidArgumentException message'),
            ],
            [
                function (): void {
                    throw new AssertionException('AssertionException message');
                },
                new AssertionException('AssertionException message'),
            ],
            [
                function (): void {
                    throw new ArithmeticError('ArithmeticError message');
                },
                new ArithmeticError('ArithmeticError message'),
            ],
        ];
    }

    public function throwingCallable(): void
    {
        throw new Exception('throwingCallable message');
    }
}
