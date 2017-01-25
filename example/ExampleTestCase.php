<?php declare(strict_types=1);

namespace Example;

use Inphest\Framework\Hooks\AfterTest;
use Inphest\Assertions\AssertionException;
use Inphest\Framework\Hooks\HasHooksInterface;
use Inphest\Framework\Hooks\AfterTestInterface;
use Inphest\Framework\Results\TestResultInterface;

class ExampleTestCase implements HasHooksInterface, AfterTestInterface
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
        ];
    }

    public function afterTest(TestResultInterface $result) : void
    {
        echo PHP_EOL .  '!!!After Test'. PHP_EOL;
    }
}
