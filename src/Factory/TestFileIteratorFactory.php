<?php declare(strict_types=1);

namespace Inphest\Framework\Factory;

use Iterator;
use FilesystemIterator;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

use Inphest\Framework\TestFileFilterIterator;

final class TestFileIteratorFactory
{
    /**
     * @param string $directory the directory containing test files to run
     * @return RunCommand
     */
    public function create(string $directory) : Iterator
    {
        $flags = FilesystemIterator::KEY_AS_PATHNAME
            | FilesystemIterator::CURRENT_AS_FILEINFO
            | FilesystemIterator::SKIP_DOTS;

        $iterator = new RecursiveDirectoryIterator($directory, $flags);
        $iterator = new RecursiveIteratorIterator($iterator);

        return new TestFileFilterIterator($iterator);
    }
}
