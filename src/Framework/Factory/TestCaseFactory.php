<?php declare(strict_types=1);

namespace Inphest\Framework\Factory;

use ReflectionClass;
use ReflectionMethod;

use Inphest\Framework\TestCase;
use Inphest\Framework\TestCaseInterface;
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

        $reflectionClass = new ReflectionClass($instance);

        // grap all the methods starting with 'test'
        // TODO make this less gross
        $testMethods = array_filter(array_map(function (ReflectionMethod $method) {
            return $method->name;
        }, $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC)), function (string $method) {
            return strpos($method, 'test') === 0;
        });

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
