<?php

declare(strict_types=1);

namespace Inphest;

interface TestSuiteConfigInterface
{
    /**
     * @psalm-return iterable<class-string>
     */
    public function getTestCases(): iterable;
}
