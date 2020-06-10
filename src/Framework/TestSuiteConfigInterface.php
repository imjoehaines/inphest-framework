<?php

declare(strict_types=1);

namespace Inphest\Framework;

interface TestSuiteConfigInterface
{
    /**
     * @psalm-return iterable<class-string>
     */
    public function getTestCases(): iterable;
}
