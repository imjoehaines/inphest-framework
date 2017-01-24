<?php declare(strict_types=1);

namespace Inphest\Framework\Hooks;

use Inphest\Framework\TestCase;

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
