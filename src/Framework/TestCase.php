<?php declare(strict_types=1);

namespace Inphest\Framework;

use Inphest\Assertions\AssertionException;

final class TestCase
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $instance;

    /**
     * @param mixed $instance
     * @param array $testMethods
     */
    public function __construct($instance, array $testMethods)
    {
        $this->instance = $instance;
        $this->testMethods = $testMethods;
    }

    public function getName() : string
    {
        return get_class($this->instance);
    }

    public function getTestMethods() : iterable
    {
        return $this->testMethods;
    }

    public function runTest(string $testName) : TestResultInterface
    {
        try {
            $this->instance->$testName();

            return new PassingTest($testName);
        } catch (AssertionException $e) {
            return new FailingTest($testName, $e);
        }
    }
}
