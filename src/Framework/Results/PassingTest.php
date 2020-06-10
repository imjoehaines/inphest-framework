<?php

declare(strict_types=1);

namespace Inphest\Framework\Results;

final class PassingTest implements TestResultInterface
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getOutput(): string
    {
        return '✔ ' . $this->name;
    }

    public function isFailure(): bool
    {
        return false;
    }
}
