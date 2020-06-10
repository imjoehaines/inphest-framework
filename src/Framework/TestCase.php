<?php

declare(strict_types=1);

namespace Inphest\Framework;

use Closure;
use Inphest\Assertions\Assert;
use Inphest\Assertions\AssertionException;
use Inphest\Framework\Results\FailingTest;
use Inphest\Framework\Results\PassingTest;
use Inphest\Framework\Results\TestResultInterface;

final class TestCase implements TestCaseInterface
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
        foreach ($this->testMethods as $name) {
            $method = Closure::fromCallable([$this->instance, $name]);

            yield $this->runMethod($name, $method);
        }
    }

    private function runMethod(string $testName, Closure $method): TestResultInterface
    {
        try {
            $method($this->assert);

            return new PassingTest($testName);
        } catch (AssertionException $e) {
            return new FailingTest($testName, $e);
        }
    }
}
