<?php

declare(strict_types=1);

namespace Inphest\Internal;

use Closure;
use Inphest\Assert;
use Inphest\Internal\Result\FailingTest;
use Inphest\Internal\Result\PassingTest;
use Inphest\Internal\Result\TestResultInterface;

final class TestCase
{
    private string $label;
    private Closure $test;

    public function __construct(string $label, Closure $test)
    {
        $this->label = $label;
        $this->test = $test;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function run(Assert $assert): TestResultInterface
    {
        try {
            ($this->test)($assert);

            return new PassingTest($this->label);
        } catch (AssertionException $failureReason) {
            return new FailingTest($this->label, $failureReason);
        }
    }
}
