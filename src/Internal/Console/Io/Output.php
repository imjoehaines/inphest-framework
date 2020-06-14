<?php

declare(strict_types=1);

namespace Inphest\Internal\Console\Io;

final class Output implements OutputInterface
{
    public function write(string $line): void
    {
        echo $line;
    }

    public function writeln(string $line): void
    {
        $this->write($line . "\n");
    }
}
