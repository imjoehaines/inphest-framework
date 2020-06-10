<?php declare(strict_types=1);

namespace Inphest\Framework;

use Inphest\Assertions\Assert;
use Inphest\Assertions\AssertionException;
use Inphest\Framework\Results\PassingTest;
use Inphest\Framework\Results\FailingTest;
use Inphest\Framework\Results\TestResultInterface;

final class TestCase implements TestCaseInterface
{
    /**
     * @var mixed
     */
    private $instance;

    private array $testMethods;

    /**
     * @param mixed $instance
     * @param array $testMethods
     */
    public function __construct($instance, array $testMethods)
    {
        $this->instance = $instance;
        $this->testMethods = $testMethods;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return get_class($this->instance);
    }

    /**
     * @return iterable
     */
    public function getTestMethods() : iterable
    {
        return $this->testMethods;
    }

    /**
     * @param string $testName
     * @return TestResultInterface
     */
    public function runTest(string $testName) : TestResultInterface
    {
        try {
            $this->instance->$testName(new Assert());

            return new PassingTest($testName);
        } catch (AssertionException $e) {
            return new FailingTest($testName, $e);
        }
    }
}
