<?php

declare(strict_types=1);

namespace Inphest\Internal;

use Inphest\Assert;
use Inphest\Internal\Printer\PrinterInterface;
use Inphest\Internal\Result\TestSuiteResult;

final class TestRunner
{
    private Stopwatch $stopwatch;
    private PrinterInterface $printer;

    public function __construct(
        Stopwatch $stopwatch,
        PrinterInterface $printer
    ) {
        $this->stopwatch = $stopwatch;
        $this->printer = $printer;
    }

    public function run(): TestSuiteResult
    {
        $results = new TestSuiteResult();
        $assert = new Assert();

        $timeTaken = $this->stopwatch->measure(function () use ($results, $assert): void {
            foreach (TestRegistry::iterate() as $testCase) {
                $this->printer->test($testCase);

                $result = $testCase->run($assert);
                $results->add($result);

                if ($result->isFailure()) {
                    $this->printer->failure($result);
                } else {
                    $this->printer->success($result);
                }
            }
        });

        $this->printer->summary($timeTaken, $results);

        return $results;
    }
}
