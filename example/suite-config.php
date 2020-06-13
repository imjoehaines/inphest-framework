<?php declare(strict_types=1);

namespace Example;

use Inphest\TestSuiteConfigInterface;

return new class implements TestSuiteConfigInterface {
    /**
     * @return iterable
     */
    public function getTestCases() : iterable
    {
        return [
            ExampleTestCase::class,
            ExampleTestCase2::class,
        ];
    }
};
