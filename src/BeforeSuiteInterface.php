<?php declare(strict_types=1);

namespace Inphest\Framework;

interface BeforeSuiteInterface
{
    /**
     * Method to run before the suite has started
     *
     * @return void
     */
    public function beforeSuite() : void;
}
