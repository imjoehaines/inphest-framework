<?php declare(strict_types=1);

namespace Inphest\Framework\Hooks;

use Inphest\Framework\TestCaseInterface;
use Inphest\Framework\Hooks\AfterTestInterface;
use Inphest\Framework\Results\TestResultInterface;

class AfterTest implements TestCaseInterface
{
    /**
     * @param TestCaseInterface $testCase
     * @param AfterTestInterface $instance
     */
    public function __construct(TestCaseInterface $testCase, AfterTestInterface $instance)
    {
        $this->testCase = $testCase;
        $this->instance = $instance;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->testCase->getName();
    }

    /**
     * @return iterable
     */
    public function getTestMethods() : iterable
    {
        return $this->testCase->getTestMethods();
    }

    /**
     * Run a test and the after hook
     *
     * @param string $testName
     * @return TestResultInterface
     */
    public function runTest(string $testName) : TestResultInterface
    {
        $result = $this->testCase->runTest($testName);

        $this->instance->afterTest($result);

        return $result;
    }
}
