<?php declare(strict_types=1);

namespace Inphest\Framework;

interface TestSuiteConfigInterface
{
    /**
     * @return iterable a list of all tests in this suite
     */
    public function getTests() : iterable;
}
