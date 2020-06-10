<?php

declare(strict_types=1);

namespace Example;

use Inphest\Framework\TestSuiteConfigInterface;

require_once 'ExampleTestCase.php';
require_once 'ExampleTestCase2.php';

return new class() implements TestSuiteConfigInterface {
    /**
     * @return iterable
     */
    public function getTestCases(): iterable
    {
        return [
            ExampleTestCase::class,
            ExampleTestCase2::class,
        ];
    }
};
