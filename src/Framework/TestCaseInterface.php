<?php declare(strict_types=1);

namespace Inphest\Framework;

use Inphest\Framework\Results\TestResultInterface;

interface TestCaseInterface
{
    public function getName() : string;

    public function getTests() : iterable;

    public function runTest(string $testName) : TestResultInterface;
}
