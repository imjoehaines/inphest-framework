<?php

declare(strict_types=1);

namespace Inphest\Internal\Console\Io;

interface OutputInterface
{
    public function write(string $line): void;
    public function writeln(string $line): void;
}
