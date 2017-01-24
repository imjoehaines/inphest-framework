<?php declare(strict_types=1);

namespace Inphest\Framework;

interface TestResultInterface
{
    public function getOutput() : string;

    public function isFailure() : bool;
}
