<?php

declare(strict_types=1);

namespace Inphest\Internal\Printer;

use Inphest\Internal\Result\FailingTestResultInterface;
use Inphest\Internal\Result\TestResultInterface;
use Inphest\Internal\Result\TestSuiteResult;

interface PrinterInterface
{
    public function heading(string $heading): void;
    public function success(TestResultInterface $result): void;
    public function failure(FailingTestResultInterface $result): void;
    public function summary(TestSuiteResult $result): void;
}
