<?php declare(strict_types=1);

namespace Inphest\Assertions\Tests;

use Closure;
use stdClass;
use Exception;
use ArithmeticError;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

use Inphest\Assertions\Assert;
use Inphest\Assertions\AssertionException;

final class AssertTest extends TestCase
{
    /**
     * @dataProvider strictEqualProvider
     *
     * @param mixed $expected
     * @param mixed $actual
     * @return void
     */
    public function testSamePassesForStrictlyEqualValues($expected, $actual) : void
    {
        $assert = new Assert();
        $assert->same($expected, $actual);
    }

    /**
     * @dataProvider equalProvider
     * @dataProvider notEqualProvider
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     * @return void
     */
    public function testSameFailsForValuesNotStrictlyEqual($expected, $actual, $message) : void
    {
        $this->setExpectedException(
            AssertionException::class,
            $message
        );

        $assert = new Assert();
        $assert->same($expected, $actual);
    }

    /**
     * @dataProvider throwingCallbackProvider
     *
     * @return void
     */
    public function testThrowsPassesWhenCallableThrowsTheCorrectException(
        callable $callback,
        string $exception,
        string $message
    ) : void {
        $assert = new Assert();
        $assert->throws($callback, $exception, $message);
    }

    /**
     * @return void
     */
    public function testThrowsFailsForCallbacksThatDoNotThrow() : void
    {
        $this->setExpectedException(
            AssertionException::class,
            'Given callable did not throw (expecting "Exception")'
        );

        $assert = new Assert();
        $assert->throws(function () {
            // noop
        }, Exception::class);
    }

    /**
     * @return void
     */
    public function testThrowsFailsForExceptionsWithIncorrectMessages() : void
    {
        $this->setExpectedException(
            AssertionException::class,
            '"Not the right message" does not match expected message "A message"'
        );

        $assert = new Assert();
        $assert->throws(
            function () {
                throw new Exception('Not the right message');
            },
            Exception::class,
            'A message'
        );
    }

    public function strictEqualProvider() : array
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

    public function equalProvider() : array
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

    public function notEqualProvider() : array
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

    public function throwingCallbackProvider() : array
    {
        return [
            [[$this, 'throwingCallable'], Exception::class, 'throwingCallable message'],
            [
                function () {
                    throw new Exception('Exception message');
                },
                Exception::class,
                'Exception message',
            ],
            [
                function () {
                    throw new InvalidArgumentException('InvalidArgumentException message');
                },
                InvalidArgumentException::class,
                'InvalidArgumentException message',
            ],
            [
                function () {
                    throw new AssertionException('AssertionException message');
                },
                AssertionException::class,
                'AssertionException message',
            ],
            [
                function () {
                    throw new ArithmeticError('ArithmeticError message');
                },
                ArithmeticError::class,
                'ArithmeticError message',
            ],
        ];
    }

    public function throwingCallable()
    {
        throw new Exception('throwingCallable message');
    }
}
