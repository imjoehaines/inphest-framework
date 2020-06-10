<?php

declare(strict_types=1);

namespace Inphest\Framework\Results;

use Throwable;

final class FailingTest implements TestResultInterface
{
    private string $name;
    private Throwable $failure;

    public function __construct(string $name, Throwable $failure)
    {
        $this->name = $name;
        $this->failure = $failure;
    }

    public function getOutput(): string
    {
        return '✘ ' . $this->name . ' — ' . $this->failure->getMessage();
    }

    public function isFailure(): bool
    {
        return true;
    }
}
