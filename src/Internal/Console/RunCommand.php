<?php

declare(strict_types=1);

namespace Inphest\Internal\Console;

use FilesystemIterator;
use Inphest\Internal\Console\Io\InputInterface;
use Inphest\Internal\Console\Io\OutputInterface;
use Inphest\Internal\Printer\PrettyPrinter;
use Inphest\Internal\Printer\SimplePrinter;
use Inphest\Internal\Stopwatch;
use Inphest\Internal\TestRegistry;
use Inphest\Internal\TestRunner;
use InvalidArgumentException;
use RecursiveDirectoryIterator;

final class RunCommand
{
    private const SUCCESS = 0;
    private const FAILURE = 1;

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $path = $input->getArgument(1);

        if (!is_string($path)) {
            $path = 'tests';
        }

        $path = getcwd() . "/{$path}";

        if (!file_exists($path) || !is_dir($path)) {
            throw new InvalidArgumentException(
                "The given directory '{$path}' does not exist"
            );
        }

        $output->writeln('Inphest v0.0.0');

        $iterator = new RecursiveDirectoryIterator(
            $path,
            FilesystemIterator::CURRENT_AS_PATHNAME | FilesystemIterator::SKIP_DOTS
        );

        /** @var string $file */
        foreach ($iterator as $file) {
            // Convert the absolute path to be relative from $path
            $relativePath = substr($file, strlen("{$path}/"));

            TestRegistry::setFile(basename($relativePath, '.php'));

            /** @psalm-suppress UnresolvableInclude */
            require $file;
        }

        // TODO load this from config
        $usePrettyPrinter = !!1;

        $printer = $usePrettyPrinter
            ? new PrettyPrinter($output)
            : new SimplePrinter($output);

        $runner = new TestRunner(new Stopwatch(), $printer);

        $result = $runner->run();

        if ($result->hasFailures()) {
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
