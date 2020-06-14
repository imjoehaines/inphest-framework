<?php

declare(strict_types=1);

namespace Inphest\Internal;

use Inphest\Internal\Console\Io\OutputInterface;
use Inphest\Internal\Result\TestSuiteResult;
use Inphest\TestSuiteConfigInterface;

final class TestRunner
{
    private OutputInterface $output;
    private TestCaseRunnerFactory $factory;
    private Stopwatch $stopwatch;

    public function __construct(
        OutputInterface $output,
        TestCaseRunnerFactory $factory,
        Stopwatch $stopwatch
    ) {
        $this->output = $output;
        $this->factory = $factory;
        $this->stopwatch = $stopwatch;
    }

    public function run(TestSuiteConfigInterface $config): TestSuiteResult
    {
        $this->output->writeln('Inphest v0.0.0');

        $results = new TestSuiteResult();

        $timeTaken = $this->stopwatch->measure(function () use ($config, $results): void {
            foreach ($config->getTestCases() as $testCaseClass) {
                $testCase = $this->factory->create($testCaseClass);

                $this->output->writeln('');
                $this->output->writeln($testCase->getName());

                foreach ($testCase->run() as $result) {
                    $results->add($result);

                    if ($result->isFailure()) {
                        $this->output->writeln('  ✘ ' . $result->getName());
                        $this->output->writeln('      Fail! ' . $result->getFailure()->getMessage());
                    } else {
                        $this->output->writeln('  ✔ ' . $result->getName());
                    }
                }
            }
        });

        $summary = sprintf(
            'Ran %d tests in %s',
            $results->count(),
            TimeFormatter::format($timeTaken)
        );

        $this->output->writeln('');
        $this->output->writeln($results->hasFailures() ? 'Fail!' : 'Success!');
        $this->output->writeln($summary);

        return $results;
    }
}
