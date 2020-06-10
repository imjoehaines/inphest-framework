<?php

declare(strict_types=1);

namespace Inphest\Framework\Results;

interface TestResultInterface
{
    /**
     * @return string
     */
    public function getOutput(): string;

    /**
     * @return bool
     */
    public function isFailure(): bool;
}
