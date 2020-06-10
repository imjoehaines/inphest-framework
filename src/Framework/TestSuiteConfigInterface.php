<?php

declare(strict_types=1);

namespace Inphest\Framework;

interface TestSuiteConfigInterface
{
    /**
     * @return iterable a list of all test cases in this suite
     */
    public function getTestCases(): iterable;
}
