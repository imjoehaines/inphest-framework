<?php declare(strict_types=1);

namespace Inphest\Framework\Factory;

use ReflectionClass;
use ReflectionMethod;

use Inphest\Framework\TestCase;

final class TestCaseFactory
{
    public function create(string $fullyQualifiedClassname) : TestCase
    {
        $instance = new $fullyQualifiedClassname;

        $reflectionClass = new ReflectionClass($instance);

        $testMethods = array_map(function (ReflectionMethod $method) {
            return $method->name;
        }, $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC));

        $testCase = new TestCase($instance, $testMethods);

        // TODO make this not an awful name
        // wrap the test case in all of its requested hooks
        if ($instance instanceof TestCaseWithHooksInterface) {
            $hooks = $instance->getHooks();

            foreach ($hooks as $hook) {
                $instance = new $hook($instance);
            }
        }

        return $testCase;
    }
}
