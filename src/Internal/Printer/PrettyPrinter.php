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
        $name = $this->output->bold($test->getName());

        $this->output->writeln("\n{$name}");
    }

    public function success(TestResultInterface $result): void
    {
        $tick = $this->output->green('✔');

        $this->output->writeln("  {$tick} {$result->getName()}");
    }

    public function failure(FailingTest $result): void
    {
        $cross = $this->output->red('✘');
        $name = $this->output->bold($result->getName());

        $this->output->writeln(
            <<<MESSAGE
              {$cross} {$name}
                  {$result->getFailure()->getMessage()}
            MESSAGE
        );
    }

    public function summary(int $timeTaken, TestSuiteResult $result): void
    {
        $time = TimeFormatter::format($timeTaken);
        $successOrFail = $result->hasFailures()
            ? $this->output->bold($this->output->red('FAIL'))
            : $this->output->bold($this->output->green('SUCCESS'));

        $this->output->writeln(
            <<<MESSAGE

            {$successOrFail}
            Ran {$result->count()} tests in {$time}
            MESSAGE
        );
    }
}
