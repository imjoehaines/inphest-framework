<?php

declare(strict_types=1);

namespace Inphest\Internal\Console;

use Inphest\Internal\Console\Io\InputInterface;
use Inphest\Internal\Console\Io\OutputInterface;
use Inphest\Internal\Stopwatch;
use Inphest\Internal\TestCaseRunnerFactory;
use Inphest\Internal\TestRunner;
use Inphest\TestSuiteConfigInterface;
use InvalidArgumentException;

final class RunCommand
{
    private const SUCCESS = 0;
    private const FAILURE = 1;

    private TestCaseRunnerFactory $testCaseFactory;

    public function __construct(TestCaseRunnerFactory $testCaseFactory)
    {
        $this->testCaseFactory = $testCaseFactory;
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $suiteConfigPath = $input->getArgument(1);

        if (!is_string($suiteConfigPath)) {
            throw new InvalidArgumentException('No suite config file given');
        }

        $suiteConfigPath = getcwd() . "/{$suiteConfigPath}";

        if (!file_exists($suiteConfigPath)) {
            throw new InvalidArgumentException(
                "The given config file '{$suiteConfigPath}' does not exist"
            );
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

        $runner = new TestRunner($output, $this->testCaseFactory, new Stopwatch());
        $result = $runner->run($suiteConfig);

        if ($result->hasFailures()) {
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
