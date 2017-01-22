<?php declare(strict_types=1);

namespace Inphest\Framework;

interface AfterSuiteInterface
{
    /**
     * Method to run after the suite has ended
     *
     * TODO: give this a SuiteResult parameter ?
     *
     * @return void
     */
    public function afterSuite() : void;
}
