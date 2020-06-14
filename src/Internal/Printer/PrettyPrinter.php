<?php

declare(strict_types=1);

namespace Inphest\Internal\Printer;

use Inphest\Internal\Console\Io\OutputInterface;
use Inphest\Internal\Result\FailingTest;
use Inphest\Internal\Result\TestResultInterface;
use Inphest\Internal\Result\TestSuiteResult;
use Inphest\Internal\TestCaseRunner;
use Inphest\Internal\TimeFormatter;

final class PrettyPrinter implements PrinterInterface
{
    private OutputInterface $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function test(TestCaseRunner $test): void
    {
        $this->output->writeln("\n{$test->getName()}");
    }

    public function success(TestResultInterface $result): void
    {
        $this->output->writeln("  ✔ {$result->getName()}");
    }

    public function failure(FailingTest $result): void
    {
        $this->output->writeln(
            <<<MESSAGE
              ✘ {$result->getName()}
                  Fail! {$result->getFailure()->getMessage()}
            MESSAGE
        );
    }

    public function summary(int $timeTaken, TestSuiteResult $result): void
    {
        $successOrFail = $result->hasFailures() ? 'FAIL' : 'SUCCESS';
        $time = TimeFormatter::format($timeTaken);

        $this->output->writeln(
            <<<MESSAGE

            {$successOrFail}
            Ran {$result->count()} tests in {$time}
            MESSAGE
        );
    }
}
