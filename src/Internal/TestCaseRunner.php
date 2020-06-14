<?php

declare(strict_types=1);

namespace Inphest\Internal;

use Inphest\Assert;
use Inphest\Internal\Result\FailingTest;
use Inphest\Internal\Result\PassingTest;
use Inphest\Internal\Result\TestResultInterface;

final class TestCaseRunner
{
    private object $instance;

    /**
     * @psalm-var list<string>
     */
    private array $testMethods;

    private Assert $assert;

    public function __construct(
        object $instance,
        TestMethodExtractor $extractor,
        Assert $assert
    ) {
        $this->instance = $instance;
        $this->testMethods = $extractor->extract($instance);
        $this->assert = $assert;
    }

    public function getName(): string
    {
        return get_class($this->instance);
    }

    /**
     * @psalm-return iterable<TestResultInterface>
     */
    public function run(): iterable
    {
        foreach ($this->testMethods as $method) {
            yield $this->runMethod($method);
        }
    }

    private function runMethod(string $method): TestResultInterface
    {
        try {
            /** @psalm-suppress MixedMethodCall */
            $this->instance->{$method}($this->assert);

            return new PassingTest($method);
        } catch (AssertionException $e) {
            return new FailingTest($method, $e);
        }
    }
}
