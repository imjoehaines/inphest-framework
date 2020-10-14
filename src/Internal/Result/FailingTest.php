<?php

declare(strict_types=1);

namespace Inphest\Internal\Result;

use Throwable;

final class FailingTest implements FailingTestResultInterface
{
    private string $label;
    private Throwable $failureReason;

    public function __construct(string $label, Throwable $failureReason)
    {
        $this->label = $label;
        $this->failureReason = $failureReason;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getFailureReason(): Throwable
    {
        return $this->failureReason;
    }

    public function isFailure(): bool
    {
        return true;
    }
}
