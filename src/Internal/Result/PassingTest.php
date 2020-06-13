<?php

declare(strict_types=1);

namespace Inphest\Internal\Result;

final class PassingTest implements TestResultInterface
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isFailure(): bool
    {
        return false;
    }
}
