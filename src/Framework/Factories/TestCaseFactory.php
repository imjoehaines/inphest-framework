<?php declare(strict_types=1);

namespace Inphest\Framework\Factories;

use Inphest\Assertions\Assert;
use Inphest\Framework\TestCase;
use Inphest\Framework\TestCaseInterface;
use Inphest\Framework\TestMethodExtractor;

final class TestCaseFactory
{
    private Assert $assert;

    public function __construct(Assert $assert)
    {
        $this->assert = $assert;
    }

    /**
     * Create a new TestCase from the given class name
     *
     * @param string $fullyQualifiedClassname
     * @return TestCaseInterface
     */
    public function create(string $fullyQualifiedClassname) : TestCaseInterface
    {
        $instance = new $fullyQualifiedClassname;

        $testMethods = TestMethodExtractor::extract($instance);

        return new TestCase($instance, $testMethods, $this->assert);
    }
}
