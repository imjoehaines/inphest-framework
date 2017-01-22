<?php declare(strict_types=1);

namespace Inphest\Framework\Console;

use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Inphest\Framework\AfterTestInterface;
use Inphest\Framework\AfterSuiteInterface;
use Inphest\Framework\BeforeTestInterface;
use Inphest\Framework\BeforeSuiteInterface;
use Inphest\Framework\TestSuiteConfigInterface;

final class RunCommand extends Command
{
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

        // 1. check file exists
        if (!file_exists($suiteConfigPath)) {
            throw new InvalidArgumentException(sprintf(
                'Unable to find a config file at "%s"',
                $suiteConfigPath
            ));
        }

        // 2. include file
        // 3. ensure implements TestSuiteConfigInterface
        $suiteConfig = $this->getConfig($suiteConfigPath);

        // TODO: move this logic to a TestRunner

        // TODO: implement this as a decorator
        // 4. call beforeSuite if suite implements BeforeSuiteInterface
        if ($suiteConfig instanceof BeforeSuiteInterface) {
            $suiteConfig->beforeSuite();
        }

        // 5. getTests()
        // 6. iterate over result and:
        foreach ($suiteConfig->getTests() as $test) {
            // TODO: implement this as a decorator
            //    - call `suite::beforeTest` if suite implements BeforeTestInterface
            if ($suiteConfig instanceof BeforeTestInterface) {
                $suiteConfig->beforeTest($test);
            }

            // TODO: implement this as a decorator
            //    - call `test::beforeTest` if test implements BeforeTestInterface
            if ($test instanceof BeforeTestInterface) {
                $test->beforeTest($test);
            }

            // TODO
            //    - get test methods (public methods starting with "test")
            //    foreach test method:
            //        - call test method
            //        - print test results
            //        - track if failure

            // TODO: implement this as a decorator
            //    - call `test::afterTest` if test implements AfterTestInterface
            if ($test instanceof AfterTestInterface) {
                $test->afterTest($test);
            }

            // TODO: implement this as a decorator
            //    - call `suite::afterTest` if suite implements AfterTestInterface
            if ($suiteConfig instanceof AfterTestInterface) {
                $suiteConfig->afterTest($test);
            }
        }

        // 7. call afterSuite if suite implements AfterSuiteInterface
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
