<?php declare(strict_types=1);

namespace Inphest\Framework;

use ReflectionClass;
use ReflectionMethod;

class TestMethodExtractor
{
    /**
     * Extract test method names from the given class instance
     *
     * @param mixed $instance
     * @return array
     */
    public static function extract($instance) : array
    {
        $reflectionClass = new ReflectionClass($instance);

        $publicMethods = array_map(function (ReflectionMethod $method) {
            return $method->name;
        }, $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC));

        // grab only methods starting with 'test'
        $testMethods = array_filter($publicMethods, function (string $method) {
            return strpos($method, 'test') === 0;
        });

        // reset indexes back to 0, 1 etc...
        return array_values($testMethods);
    }
}
