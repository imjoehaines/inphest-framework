<?php

declare(strict_types=1);

namespace Inphest\Framework\Console;

use Inphest\Framework\Console\Io\InputInterface;
use Inphest\Framework\Console\Io\OutputInterface;
use Inphest\Framework\Factories\TestCaseFactory;
use Inphest\Framework\TestSuiteConfigInterface;
use InvalidArgumentException;

final class RunCommand
{
    private const SUCCESS = 0;
    private const FAILURE = 1;

    private TestCaseFactory $testCaseFactory;

    public function __construct(TestCaseFactory $testCaseFactory)
    {
        $this->testCaseFactory = $testCaseFactory;
    }

    public function run(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $suiteConfigPath = $input->getArgument(1);

        if (!is_string($suiteConfigPath) || !file_exists($suiteConfigPath)) {
            throw new InvalidArgumentException('The given config file does not exist');
        }

        /**
         * @var mixed $suiteConfig
         * @psalm-suppress UnresolvableInclude TODO can we fix this?
         */
        $suiteConfig = require $suiteConfigPath;

        if (!$suiteConfig instanceof TestSuiteConfigInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    'Config file "%s" did not return a %s',
                    $suiteConfigPath,
                    TestSuiteConfigInterface::class
                )
            );
        }

        // TODO: move this logic to a TestRunner

        $output->writeln('Inphest v0.0.0');

        $successes = 0;
        $failures = 0;
        $start = hrtime(true);

        foreach ($suiteConfig->getTestCases() as $testCaseClass) {
            $testCase = $this->testCaseFactory->create($testCaseClass);

            $output->writeln('');
            $output->writeln($testCase->getName());

            foreach ($testCase->run() as $result) {
                if ($result->isFailure()) {
                    ++$failures;
                    $output->writeln('  ✘ ' . $result->getName());
                    $output->writeln('      Fail! ' . $result->getFailure()->getMessage());
                } else {
                    ++$successes;
                    $output->writeln('  ✔ ' . $result->getName());
                }
            }
        }

        $end = hrtime(true);

        $summary = sprintf(
            '%s! Ran %d tests in %ss',
            $failures > 0 ? 'Fail' : 'Success',
            $successes + $failures,
            round((float) ($end - $start) / 1e9, 2)
        );

        $output->writeln('');
        $output->writeln($summary);

        // end TestRunner code

        if ($failures > 0) {
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
