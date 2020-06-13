<?php

declare(strict_types=1);

namespace Inphest\Internal\Console\Io;

final class Output implements OutputInterface
{
    public function writeln(string $line): void
    {
        echo $line . "\n";
    }
}
