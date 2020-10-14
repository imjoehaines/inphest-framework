<?php

declare(strict_types=1);

namespace Inphest\Internal\Printer;

use Inphest\Internal\Console\Io\OutputInterface;
use Inphest\Internal\Result\FailingTestResultInterface;
use Inphest\Internal\Result\TestResultInterface;
use Inphest\Internal\Result\TestSuiteResult;
use Inphest\Internal\TimeFormatter;

final class PrettyPrinter implements PrinterInterface
{
    private OutputInterface $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function heading(string $heading): void
    {
        $name = $this->output->bold($heading);

        $this->output->writeln("\n{$name}");
    }

    public function success(TestResultInterface $result): void
    {
        $tick = $this->output->green('✔');
        $name = $result->getLabel();

        $this->output->writeln("  {$tick} {$name}");
    }

    public function failure(FailingTestResultInterface $result): void
    {
        $cross = $this->output->red('✘');
        $name = $this->output->bold($result->getLabel());

        $this->output->writeln(
            <<<MESSAGE
              {$cross} {$name}
                  {$result->getFailureReason()->getMessage()}
            MESSAGE
        );
    }

    public function summary(TestSuiteResult $result): void
    {
        $time = TimeFormatter::format($result->getTimeTaken());
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
