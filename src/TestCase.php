<?php declare(strict_types=1);

namespace Inphest\Framework;

use Countable;
use ReflectionMethod;

final class TestCase implements Countable
{
    /**
     * @param string $name
     * @param mixed $testClass an instance of the class containing tests
     * @param ReflectionMethod $tests array of test methods from $testClass
     */
    public function __construct(string $name, $testClass, ReflectionMethod ...$tests)
    {
        $this->name = $name;
        $this->testClass = $testClass;
        $this->tests = $tests;
    }

    public function runTests()
    {
        foreach ($this->tests as $test) {
            $test->invoke($this->testClass);
        }
    }

    public function count() : int
    {
        return count($this->tests);
    }

    public function getName() : string
    {
        return $this->name;
    }
}
