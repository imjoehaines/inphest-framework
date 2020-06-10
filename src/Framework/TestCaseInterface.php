<?php

declare(strict_types=1);

namespace Inphest\Framework;

interface TestCaseInterface
{
    public function getName(): string;

    /**
     * @psalm-return iterable<\Inphest\Framework\Results\TestResultInterface>
     */
    public function run(): iterable;
}
