<?php

declare(strict_types=1);

namespace Inphest\Internal;

use Closure;
use Inphest\Assert;
use Inphest\Internal\Result\FailingTest;
use Inphest\Internal\Result\PassingTest;
use Inphest\Internal\Result\TestResultInterface;
use Inphest\PublicTestCase;

final class TestCase implements PublicTestCase
{
    private string $label;
    private Closure $test;

    /**
     * @var array<array-key, array<array-key, mixed>>
     */
    private array $data = [];

    /**
     * @param string $label
     * @param Closure(Assert, mixed...): void $test
     */
    public function __construct(string $label, Closure $test)
    {
        $this->label = $label;
        $this->test = $test;
    }

    /**
     * @param array<array-key, array<array-key, mixed>> $data
     * @return void
     */
    public function with(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return iterable<TestResultInterface>
     */
    public function run(Assert $assert): iterable
    {
        if ($this->data === []) {
            yield $this->runOne($assert, $this->label);

            return;
        }

        foreach ($this->data as $index => $data) {
            $label = "{$this->label} ({$index})";

            yield $this->runOne($assert, $label, $data);
        }
    }

    private function runOne(Assert $assert, string $label, array $arguments = []): TestResultInterface
    {
        try {
            ($this->test)($assert, ...$arguments);

            return new PassingTest($label);
        } catch (AssertionException $failureReason) {
            return new FailingTest($label, $failureReason);
        }
    }
}
