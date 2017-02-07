<?php declare(strict_types=1);

namespace Inphest\Framework\Factories;

use Inphest\Framework\TestCase;
use Inphest\Framework\TestCaseInterface;
use Inphest\Framework\TestMethodExtractor;
use Inphest\Framework\Hooks\HasHooksInterface;

final class TestCaseFactory
{
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

        $testCase = new TestCase($instance, $testMethods);

        // wrap the test case in all of its requested hooks
        if ($instance instanceof HasHooksInterface) {
            foreach ($instance->getHooks($instance) as $hook) {
                $testCase = new $hook($testCase, $instance);
            }
        }

        return $testCase;
    }
}
