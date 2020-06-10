<?php declare(strict_types=1);

namespace Example;

use Inphest\Assertions\AssertionException;

class ExampleTestCase
{
    public function testTheThing()
    {
        throw new AssertionException('Error Processing Request');
    }

    public function testTheThing4()
    {
    }

    public function testTheThing3()
    {
    }

    public function testTheThing2()
    {
        throw new AssertionException('Error Processing Request');
    }
}
