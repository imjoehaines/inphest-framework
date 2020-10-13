<?php

declare(strict_types=1);

namespace Inphest\Internal\Console\Io;

interface InputInterface
{
    public function getArgument(int $index): ?string;
    public function getOption(string $name): ?string;
}
