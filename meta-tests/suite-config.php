<?php

declare(strict_types=1);

namespace Inphest\MetaTests;

use Inphest\TestSuiteConfigInterface;

return new class() implements TestSuiteConfigInterface {
    /**
     * @return iterable
     */
    public function getTestCases(): iterable
    {
        return [
            AssertTest::class,
        ];
    }
};
