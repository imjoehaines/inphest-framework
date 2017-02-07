<?php declare(strict_types=1);

namespace Example;

use Inphest\Framework\Hooks\AfterTest;
use Inphest\Framework\Hooks\BeforeTest;
use Inphest\Assertions\AssertionException;
use Inphest\Framework\Hooks\HasHooksInterface;
use Inphest\Framework\Hooks\AfterTestInterface;
use Inphest\Framework\Hooks\BeforeTestInterface;
use Inphest\Framework\Results\TestResultInterface;

class ExampleTestCase implements HasHooksInterface, AfterTestInterface, BeforeTestInterface
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

    public function getHooks() : iterable
    {
        return [
            AfterTest::class,
            BeforeTest::class,
        ];
    }

    public function afterTest(TestResultInterface $result) : void
    {
    }

    public function beforeTest() : void
    {
    }
}
