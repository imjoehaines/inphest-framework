<?php declare(strict_types=1);

namespace Inphest\Framework\Hooks;

use Inphest\Framework\Results\TestResultInterface;

interface AfterTestInterface
{
    /**
     * Method to run after each test in a file
     *
     * @param TestResultInterface $result
     * @return void
     */
    public function afterTest(TestResultInterface $result) : void;
}
