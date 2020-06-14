<?php

declare(strict_types=1);

namespace Inphest\Internal\Printer;

use Inphest\Internal\Console\Io\OutputInterface;
use Inphest\Internal\Result\FailingTest;
use Inphest\Internal\Result\TestResultInterface;
use Inphest\Internal\Result\TestSuiteResult;
use Inphest\Internal\TestCaseRunner;
use Inphest\Internal\TimeFormatter;

final class SimplePrinter implements PrinterInterface
{
    private OutputInterface $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function test(TestCaseRunner $test): void
    {
    }

    public function success(TestResultInterface $result): void
    {
        $this->output->write('✔');
    }

    public function failure(FailingTest $result): void
    {
        $this->output->write('✘');
    }

    public function summary(int $timeTaken, TestSuiteResult $result): void
    {
        if ($result->hasFailures()) {
            $failures = $result->failures();
            $numberOfFailures = count($failures);

            $this->output->writeln("\n\n{$numberOfFailures} failures:");

            /** @var FailingTest $failure */
            foreach ($failures as $failure) {
                $this->output->writeln(
                    "  {$failure->getName()} — {$failure->getFailure()->getMessage()}"
                );
            }
        }


        $successOrFail = $result->hasFailures() ? 'FAIL' : 'SUCCESS';
        $time = TimeFormatter::format($timeTaken);

        $this->output->writeln("\n{$successOrFail} ({$time})");
    }
}
