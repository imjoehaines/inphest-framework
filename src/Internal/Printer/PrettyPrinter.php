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
        $name = $this->prettifyMethodName($result->getName());

        $this->output->writeln("  {$tick} {$name}");
    }

    public function failure(FailingTest $result): void
    {
        $cross = $this->output->red('✘');
        $name = $this->output->bold($this->prettifyMethodName($result->getName()));

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

    private function prettifyMethodName(string $method): string
    {
        $testName = '';
        $inNumber = false;

        // Skip the first 4 characters as we know they are 'test'
        for ($i = 4; $i < strlen($method); ++$i) {
            $character = $method[$i];
            $asciiCode = ord($character);

            if ($i !== 4 && $asciiCode >= 65 && $asciiCode <= 90) {
                // If the character is uppercase ASCII and not the first
                // character, add a space before it and lowercase it
                $testName .= ' ' . chr($asciiCode + 32);
                $inNumber = false;
            } elseif ($asciiCode >= 48 && $asciiCode <= 57) {
                // If the character is a number, add a space before the first
                // number in this set of numbers (i.e. before '1' in '123')
                if (!$inNumber) {
                    $testName .= ' ';
                }

                $testName .= $character;
                $inNumber = true;
            } else {
                $testName .= $character;
                $inNumber = false;
            }
        }

        return $testName;
    }
}
