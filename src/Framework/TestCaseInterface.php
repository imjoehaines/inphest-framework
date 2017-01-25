<?php declare(strict_types=1);

namespace Inphest\Framework;

use Inphest\Framework\Results\TestResultInterface;

interface TestCaseInterface
{
    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @return iterable
     */
    public function getTestMethods() : iterable;

    /**
     * @param string $testName
     * @return TestResultInterface
     */
    public function runTest(string $testName) : TestResultInterface;
}
