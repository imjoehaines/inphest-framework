<?php

declare(strict_types=1);

namespace Inphest\Internal\Result;

interface TestResultInterface
{
    public function getLabel(): string;

    /**
     * @psalm-assert-if-true FailingTest $this
     */
    public function isFailure(): bool;
}
