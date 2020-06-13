<?php

declare(strict_types=1);

namespace Inphest\Framework\Console\Io;

final class Input implements InputInterface
{
    /**
     * @psalm-var array<int, string>
     */
    private array $arguments;

    /**
     * @psalm-param array<int, string> $arguments
     */
    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
    }

    public function getArgument(int $index): ?string
    {
        return $this->arguments[$index] ?? null;
    }
}
