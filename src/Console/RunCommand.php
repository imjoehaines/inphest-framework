<?php declare(strict_types=1);

namespace Inphest\Framework\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $suiteConfig = $input->getArgument('suite_config');

        // 1. check file exists
        // 2. include file
        // 3. ensure implements TestSuiteConfigInterface
        // 4. call beforeSuite if suite implements BeforeSuiteInterface
        // 5. getTests()
        // 6. iterate over result and:
        //    - call `suite::beforeTest` if suite implements BeforeTestInterface
        //    - call `test::beforeTest` if test implements BeforeTestInterface
        //    - call test method
        //    - print test results
        //    - call `test::afterTest` if test implements AfterTestInterface
        //    - call `suite::afterTest` if suite implements AfterTestInterface
        // 7. print suite results
        // 8. call afterSuite if suite implements AfterSuiteInterface
        // 9. set exit code
    }
}
