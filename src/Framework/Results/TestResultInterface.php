<?php

declare(strict_types=1);

namespace Inphest\Framework\Results;

interface TestResultInterface
{
    public function getOutput(): string;

    public function isFailure(): bool;
}
