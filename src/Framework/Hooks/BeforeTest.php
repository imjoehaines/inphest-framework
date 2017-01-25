<?php declare(strict_types=1);

namespace Inphest\Framework\Hooks;

use Inphest\Framework\TestCaseInterface;
use Inphest\Framework\Hooks\BeforeTestInterface;
use Inphest\Framework\Results\TestResultInterface;

class BeforeTest implements TestCaseInterface
{
    /**
     * @param TestCaseInterface $testCase
     * @param BeforeTestInterface $instance
     */
    public function __construct(TestCaseInterface $testCase, BeforeTestInterface $instance)
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
     * Run the before hook and a test
     *
     * @param string $testName
     * @return TestResultInterface
     */
    public function runTest(string $testName) : TestResultInterface
    {
        $this->instance->beforeTest();

        return $this->testCase->runTest($testName);
    }
}
