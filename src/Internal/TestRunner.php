<?php

declare(strict_types=1);

namespace Inphest\Internal;

use Inphest\Internal\Console\Io\OutputInterface;
use Inphest\Internal\Printer\PrinterInterface;
use Inphest\Internal\Result\TestSuiteResult;
use Inphest\TestSuiteConfigInterface;

final class TestRunner
{
    private OutputInterface $output;
    private TestCaseRunnerFactory $factory;
    private Stopwatch $stopwatch;
    private PrinterInterface $printer;

    public function __construct(
        OutputInterface $output,
        TestCaseRunnerFactory $factory,
        Stopwatch $stopwatch,
        PrinterInterface $printer
    ) {
        $this->output = $output;
        $this->factory = $factory;
        $this->stopwatch = $stopwatch;
        $this->printer = $printer;
    }

    public function run(TestSuiteConfigInterface $config): TestSuiteResult
    {
        $this->output->writeln('Inphest v0.0.0');

        $results = new TestSuiteResult();

        $timeTaken = $this->stopwatch->measure(function () use ($config, $results): void {
            foreach ($config->getTestCases() as $testCaseClass) {
                $testCase = $this->factory->create($testCaseClass);

                $this->printer->test($testCase);

                foreach ($testCase->run() as $result) {
                    $results->add($result);

                    if ($result->isFailure()) {
                        $this->printer->failure($result);
                    } else {
                        $this->printer->success($result);
                    }
                }
            }
        });

        $this->printer->summary($timeTaken, $results);

        return $results;
    }
}
