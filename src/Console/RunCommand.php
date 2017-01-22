<?php declare(strict_types=1);

namespace Inphest\Framework\Console;

use Iterator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Inphest\Framework\Factory\TestFileIteratorFactory;
use Inphest\Framework\Factory\TestCaseFactory;

final class RunCommand extends Command
{
    private const CONSOLE_WIDTH = 72;

    public function __construct(
        TestFileIteratorFactory $iteratorFactory,
        TestCaseFactory $testCaseFactory
    ) {
        parent::__construct();

        $this->iteratorFactory = $iteratorFactory;
        $this->testCaseFactory = $testCaseFactory;
    }

    protected function configure() : void
    {
        $this->setName('run')
            ->addArgument(
                'directory',
                InputArgument::REQUIRED,
                'Directory containing test files'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $before = time();

        $directory = $input->getArgument('directory');
        $iterator = $this->iteratorFactory->create($directory);

        $tests = 0;

        foreach ($iterator as $path => $file) {
            $test = $this->testCaseFactory->create($file);
            $numberOfTests = $test->count();

            $test->runTests();

            $output->writeln($test->getName() . ' (' . $numberOfTests . ')');

            $tests += $numberOfTests;
        }

        $after = time();

        $output->writeln(PHP_EOL);
        $output->writeln('Ran ' . $tests . ' tests in ' . ($after - $before) . 's');
    }
}
