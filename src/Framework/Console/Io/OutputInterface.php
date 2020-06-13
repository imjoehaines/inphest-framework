<?php

declare(strict_types=1);

namespace Inphest\Framework\Console\Io;

interface OutputInterface
{
    public function writeln(string $line): void;
}
