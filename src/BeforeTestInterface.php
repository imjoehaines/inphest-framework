<?php declare(strict_types=1);

namespace Inphest\Framework;

interface BeforeTestInterface
{
    /**
     * Method to run before each test has started
     *
     * @param TestCase $test
     * @return void
     */
    public function beforeTest(TestCase $test) : void;
}
