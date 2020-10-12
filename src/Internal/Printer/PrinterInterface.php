<?php

declare(strict_types=1);

namespace Inphest\Internal\Printer;

use Inphest\Internal\Result\FailingTest;
use Inphest\Internal\Result\TestResultInterface;
use Inphest\Internal\Result\TestSuiteResult;

interface PrinterInterface
{
    public function heading(string $heading): void;
    public function success(TestResultInterface $result): void;
    public function failure(FailingTest $result): void;
    public function summary(TestSuiteResult $result): void;
}
