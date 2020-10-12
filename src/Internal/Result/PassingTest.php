<?php

declare(strict_types=1);

namespace Inphest\Internal\Result;

final class PassingTest implements TestResultInterface
{
    private string $label;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function isFailure(): bool
    {
        return false;
    }
}
