<?php

declare(strict_types=1);

namespace Inphest\Internal\Result;

use Throwable;

interface FailingTestResultInterface extends TestResultInterface
{
    public function getFailureReason(): Throwable;
}
