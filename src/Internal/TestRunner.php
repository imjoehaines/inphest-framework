<?php

declare(strict_types=1);

namespace Inphest\Internal;

use Inphest\Assert;
use Inphest\Internal\Printer\PrinterInterface;
use Inphest\Internal\Result\TestSuiteResult;

final class TestRunner
{
    private PrinterInterface $printer;
    private Assert $assert;

    public function __construct(PrinterInterface $printer, Assert $assert)
    {
        $this->printer = $printer;
        $this->assert = $assert;
    }

    /**
     * @param iterable<string, list<TestCase>> $testRegistry
     * @return TestSuiteResult
     */
    public function run(iterable $testRegistry): TestSuiteResult
    {
        $results = [];

        $stopwatch = Stopwatch::start();

        foreach ($testRegistry as $file => $tests) {
            $this->printer->heading($file);

            foreach ($tests as $test) {
                $result = $test->run($this->assert);

                if ($result->isFailure()) {
                    $this->printer->failure($result);
                } else {
                    $this->printer->success($result);
                }

                $results[] = $result;
            }
        }

        $timeTaken = $stopwatch->lap();

        return new TestSuiteResult($results, $timeTaken);
    }
}
