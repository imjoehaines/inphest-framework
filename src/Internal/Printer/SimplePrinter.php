<?php

declare(strict_types=1);

namespace Inphest\Internal\Printer;

use Inphest\Internal\Console\Io\OutputInterface;
use Inphest\Internal\Result\FailingTestResultInterface;
use Inphest\Internal\Result\TestResultInterface;
use Inphest\Internal\Result\TestSuiteResult;
use Inphest\Internal\TimeFormatter;

final class SimplePrinter implements PrinterInterface
{
    private OutputInterface $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function heading(string $heading): void
    {
    }

    public function success(TestResultInterface $result): void
    {
        $this->output->write($this->output->green('✔'));
    }

    public function failure(FailingTestResultInterface $result): void
    {
        $this->output->write($this->output->red('✘'));
    }

    public function summary(TestSuiteResult $result): void
    {
        $this->output->writeln();

        if ($result->hasFailures()) {
            $failures = $result->failures();
            $numberOfFailures = count($failures);

            $this->output->writeln("\n{$numberOfFailures} failures:");

            /** @var FailingTestResultInterface $failure */
            foreach ($failures as $failure) {
                $this->output->writeln(
                    "  {$failure->getLabel()} — {$failure->getFailureReason()->getMessage()}"
                );
            }
        }

        $time = TimeFormatter::format($result->getTimeTaken());
        $successOrFail = $result->hasFailures()
            ? $this->output->bold($this->output->red('FAIL'))
            : $this->output->bold($this->output->green('SUCCESS'));

        $this->output->writeln("\n{$successOrFail} ({$time})");
    }
}
