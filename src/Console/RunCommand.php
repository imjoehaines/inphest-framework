<?php declare(strict_types=1);

namespace Inphest\Framework\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Inphest\Framework\Factory\TestFileIteratorFactory;

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
    }
}
