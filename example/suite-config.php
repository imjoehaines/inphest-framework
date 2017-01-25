<?php declare(strict_types=1);

namespace Example;

use Inphest\Framework\TestSuiteConfigInterface;

require_once 'ExampleTestCase.php';

return new class implements TestSuiteConfigInterface {
    /**
     * @return iterable
     */
    public function getTestCases() : iterable
    {
        return [
            ExampleTestCase::class,
        ];
    }
};
