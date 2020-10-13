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

    /**
     * @var array<array-key, mixed>
     */
    private array $arguments = [];

    /**
     * @param string $label
     * @param Closure(Assert, mixed...): void $test
     * @param array<array-key, mixed> $arguments
     */
    public function __construct(string $label, Closure $test, array $arguments)
    {
        $this->label = $label;
        $this->test = $test;
        $this->arguments = $arguments;
    }

    /**
     * @return TestResultInterface
     */
    public function run(Assert $assert): TestResultInterface
    {
        try {
            ($this->test)($assert, ...$this->arguments);

            return new PassingTest($this->label);
        } catch (AssertionException $failureReason) {
            return new FailingTest($this->label, $failureReason);
        }
    }
}
