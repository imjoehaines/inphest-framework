<?php declare(strict_types=1);

namespace Example;

use Inphest\Assertions\Assert;
use InvalidArgumentException;

class ExampleTestCase
{
    public function testOneEqualsOne(Assert $assert)
    {
        $assert->same(1, 1);
    }

    public function testOneEqualsTwo(Assert $assert)
    {
        $assert->same(1, 2);
    }

    public function testTwoEqualsTwo(Assert $assert)
    {
        $assert->same(1, 2);
    }

    public function testThrows(Assert $assert)
    {
        $assert->throws(
            function () {
                throw new InvalidArgumentException('hey');
            },
            InvalidArgumentException::class,
            'hey'
        );
    }
}
