<?php declare(strict_types=1);

namespace Inphest\Framework\Hooks;

use Inphest\Framework\TestCaseInterface;
use Inphest\Framework\Hooks\AfterTestInterface;
use Inphest\Framework\Results\TestResultInterface;

class AfterTest implements TestCaseInterface
{
    public function __construct(TestCaseInterface $testCase, AfterTestInterface $instance)
    {
        $this->testCase = $testCase;
        $this->instance = $instance;
    }

    public function getName() : string
    {
        return $this->testCase->getName();
    }

    public function getTestMethods() : iterable
    {
        return $this->testCase->getTestMethods();
    }

    public function runTest(string $testName) : TestResultInterface
    {
        $result = $this->testCase->runTest($testName);

        $this->instance->afterTest($result);

        return $result;
    }
}
