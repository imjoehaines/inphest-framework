<?php declare(strict_types=1);

namespace Inphest\Framework\Factory;

use ReflectionClass;
use ReflectionMethod;

use Inphest\Framework\TestCase;
use Inphest\Framework\Hooks\AfterTestInterface;
use Inphest\Framework\Hooks\BeforeTestInterface;

final class TestCaseFactory
{
    public function create(string $fullyQualifiedClassname) : TestCase
    {
        $instance = new $fullyQualifiedClassname;

        $reflectionClass = new ReflectionClass($instance);
        $name = $reflectionClass->getShortName();

        $testMethods = array_map(function (ReflectionMethod $method) {
            return $method->name;
        }, $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC));

        $testCase = new TestCase($name, $instance, $testMethods);

        if ($instance instanceof AfterTestInterface) {
            $testCase = new AfterHookTestCase($testCase);
        }

        return $testCase;
    }
}
