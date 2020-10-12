<?php

declare(strict_types=1);

namespace Inphest\Internal\Console\Io;

final class Output implements OutputInterface
{
    public function write(string $line): void
    {
        echo $line;
    }

    public function writeln(string $line = ''): void
    {
        $this->write("{$line}\n");
    }

    public function bold(string $value): string
    {
        return $this->escape($value, 1);
    }

    public function green(string $value): string
    {
        return $this->escape($value, 32);
    }

    public function red(string $value): string
    {
        return $this->escape($value, 31);
    }

    private function escape(string $value, int $code): string
    {
        return "\033[{$code}m{$value}\033[0m";
    }
}
