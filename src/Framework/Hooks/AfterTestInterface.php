<?php declare(strict_types=1);

namespace Inphest\Framework\Hooks;

use Inphest\Framework\TestCase;

interface AfterTestInterface
{
    /**
     * Method to run after each test has finished
     *
     * @param TestCase $test
     * @return void
     */
    public function afterTest(TestCase $test) : void;
}
