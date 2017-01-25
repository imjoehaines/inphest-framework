<?php declare(strict_types=1);

namespace Inphest\Framework\Hooks;

interface BeforeTestInterface
{
    /**
     * Method to run before each test in a file
     *
     * @return void
     */
    public function beforeTest() : void;
}
