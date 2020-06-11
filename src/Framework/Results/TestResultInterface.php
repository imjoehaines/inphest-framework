<?php

declare(strict_types=1);

namespace Inphest\Framework\Results;

interface TestResultInterface
{
    public function getName(): string;

    /**
     * @psalm-assert-if-true FailingTest $this
     */
    public function isFailure(): bool;
}
