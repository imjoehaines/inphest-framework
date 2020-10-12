<?php

declare(strict_types=1);

namespace Inphest\Internal;

use Closure;
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

    public function run(Stopwatch $stopwatch): TestSuiteResult
    {
        return TestSuiteResult::create($stopwatch, function (Closure $addResult): void {
            foreach (TestRegistry::iterate() as $file => $tests) {
                $this->printer->heading($file);

                foreach ($tests as $test) {
                    foreach ($test->run($this->assert) as $result) {
                        $addResult($result);

                        if ($result->isFailure()) {
                            $this->printer->failure($result);
                        } else {
                            $this->printer->success($result);
                        }
                    }
                }
            }
        });
    }
}
