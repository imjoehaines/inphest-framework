<?php

declare(strict_types=1);

namespace Inphest\Tests\Internal\Console\Io;

use Inphest\Internal\Console\Io\Input;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

final class InputTest extends TestCase
{
    public function testItContainsAllPositionalArguments(): void
    {
        $args = ['hello', 'darkness', 'my', 'old', 'friend'];

        $input = Input::from($args);

        foreach ($args as $index => $value) {
            $this->assertSame($value, $input->getArgument($index));
        }

        $this->assertNull($input->getArgument(count($args)));
    }

    /**
     * @dataProvider formatInputProvider
     *
     * @param list<string> $options
     * @param array<string, string> $expected
     * @return void
     */
    public function testItParsesOptions(array $options, array $expected): void
    {
        $input = Input::from($options);

        foreach ($expected as $name => $value) {
            $this->assertSame($value, $input->getOption($name));
        }
    }

    /**
     * @dataProvider formatInputProvider
     *
     * @param list<string> $options
     * @param array<string, string> $expectedOptions
     * @return void
     */
    public function testItParsesOptionsAndArguments(array $options, array $expectedOptions): void
    {
        $arguments = ['hello', 'darkness', ...$options, 'my', 'old', 'friend'];

        $input = Input::from($arguments);

        $this->assertSame('hello', $input->getArgument(0));
        $this->assertSame('darkness', $input->getArgument(1));
        $this->assertSame('my', $input->getArgument(2));
        $this->assertSame('old', $input->getArgument(3));
        $this->assertSame('friend', $input->getArgument(4));

        foreach ($expectedOptions as $name => $value) {
            $this->assertSame($value, $input->getOption($name));
        }
    }

    /**
     * @return iterable<array-key, array{list<string>, array<string, string>}>
     */
    public function formatInputProvider(): iterable
    {
        return [
            [['--format', 'simple'], ['format' => 'simple']],
            [['--format', 'pretty'], ['format' => 'pretty']],
        ];
    }

    /**
     * @dataProvider invalidArgumentProvider
     *
     * @param string $type
     * @param array $arguments
     * @return void
     */
    public function testItOnlyAllowsStrings(string $type, array $arguments): void
    {
        $this->expectExceptionObject(new InvalidArgumentException(
            "Input must be an array of strings, {$type} given"
        ));

        Input::from($arguments);
    }

    /**
     * @return iterable<array-key, array{string, list<mixed>}>
     */
    public function invalidArgumentProvider(): iterable
    {
        return [
            ['boolean', [true]],
            ['boolean', [false]],
            ['integer', [1]],
            ['integer', [PHP_INT_MAX]],
            ['double', [1.2]],
            ['double', [PHP_FLOAT_MAX]],
            ['NULL', [null]],
            ['array', [[1, 2, 3]]],
            ['object', [new stdClass()]],
        ];
    }
}
