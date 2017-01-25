<?php declare(strict_types=1);

namespace Inphest\Framework\Console;

use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Inphest\Framework\Factory\TestCaseFactory;
use Inphest\Framework\TestSuiteConfigInterface;
use Inphest\Framework\Hooks\AfterTestInterface;
use Inphest\Framework\Hooks\AfterSuiteInterface;
use Inphest\Framework\Hooks\BeforeTestInterface;
use Inphest\Framework\Hooks\BeforeSuiteInterface;

final class RunCommand extends Command
{
    private $testCaseFactory;

    public function __construct(TestCaseFactory $testCaseFactory)
    {
        parent::__construct();

        $this->testCaseFactory = $testCaseFactory;
    }

    protected function configure() : void
    {
        $this->setName('run')
            ->addArgument(
                'suite_config',
                InputArgument::REQUIRED,
                'Instance of TestSuiteConfigInterface containing configuration for the suite to run'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $suiteConfigPath = $input->getArgument('suite_config');

        if (!file_exists($suiteConfigPath)) {
            throw new InvalidArgumentException(sprintf(
                'Unable to find a config file at "%s"',
                $suiteConfigPath
            ));
        }

        $suiteConfig = $this->getConfig($suiteConfigPath);

        // TODO: move this logic to a TestRunner

        // TODO: implement this as a decorator
        if ($suiteConfig instanceof BeforeSuiteInterface) {
            $suiteConfig->beforeSuite();
        }

        foreach ($suiteConfig->getTestCases() as $testCaseClass) {
            $testCase = $this->testCaseFactory->create($testCaseClass);
            $output->writeln($testCase->getName());

            foreach ($testCase->getTestMethods() as $method) {
                $result = $testCase->runTest($method);

                $output->writeln($result->getOutput());
            }
        }

        if ($suiteConfig instanceof AfterSuiteInterface) {
            $suiteConfig->afterSuite();
        }

        // end TestRunner code

        // TODO
        // 8. print suite results

        // TODO
        // 9. set exit code
    }

    private function getConfig(string $path) : TestSuiteConfigInterface
    {
        return require $path;
    }
}
