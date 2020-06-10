<?php

declare(strict_types=1);

namespace Inphest\Framework;

use Inphest\Assertions\Assert;
use Inphest\Assertions\AssertionException;
use Inphest\Framework\Results\FailingTest;
use Inphest\Framework\Results\PassingTest;
use Inphest\Framework\Results\TestResultInterface;

final class TestCase implements TestCaseInterface
{
    /**
     * @var mixed
     */
    private $instance;

    private array $testMethods;

    private Assert $assert;

    /**
     * @param mixed $instance
     */
    public function __construct($instance, array $testMethods, Assert $assert)
    {
        $this->instance = $instance;
        $this->testMethods = $testMethods;
        $this->assert = $assert;
    }

    public function getName(): string
    {
        return get_class($this->instance);
    }

    public function getTestMethods(): iterable
    {
        return $this->testMethods;
    }

    public function runTest(string $testName): TestResultInterface
    {
        try {
            $this->instance->{$testName}($this->assert);

            return new PassingTest($testName);
        } catch (AssertionException $e) {
            return new FailingTest($testName, $e);
        }
    }
}
