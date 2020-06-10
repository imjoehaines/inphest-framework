<?php

declare(strict_types=1);

namespace Inphest\Framework\Console;

use Inphest\Framework\Factories\TestCaseFactory;
use Inphest\Framework\TestSuiteConfigInterface;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RunCommand extends Command
{
    private TestCaseFactory $testCaseFactory;

    public function __construct(TestCaseFactory $testCaseFactory)
    {
        parent::__construct();

        $this->testCaseFactory = $testCaseFactory;
    }

    protected function configure(): void
    {
        $this->setName('run')
            ->addArgument(
                'suite_config',
                InputArgument::REQUIRED,
                'Instance of TestSuiteConfigInterface containing configuration for the suite to run'
            );
    }

    /**
     * @throws InvalidArgumentException when config file doesn't exist
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $suiteConfigPath = $input->getArgument('suite_config');

        if (!is_string($suiteConfigPath) || !file_exists($suiteConfigPath)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Unable to find a config file at "%s"',
                    is_string($suiteConfigPath)
                        ? $suiteConfigPath
                        : var_export($suiteConfigPath, true)
                )
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

        // TODO: move this logic to a TestRunner

        $exitCode = self::SUCCESS;

        foreach ($suiteConfig->getTestCases() as $testCaseClass) {
            $testCase = $this->testCaseFactory->create($testCaseClass);

            $output->writeln($testCase->getName());

            foreach ($testCase->run() as $result) {
                $output->writeln('  ' . $result->getOutput());

                if ($result->isFailure()) {
                    $exitCode = self::FAILURE;
                }
            }
        }

        // end TestRunner code

        // TODO
        // print suite results

        return $exitCode;
    }
}
