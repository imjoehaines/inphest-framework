<?php

declare(strict_types=1);

namespace Inphest\Framework;

use ReflectionClass;
use ReflectionMethod;

final class TestMethodExtractor
{
    /**
     * Extract test method names from the given class instance.
     *
     * @param mixed $instance
     *
     * @return array
     */
    public static function extract($instance): array
    {
        $reflectionClass = new ReflectionClass($instance);

        $publicMethods = array_map(
            fn (ReflectionMethod $method): string => $method->getName(),
            $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC)
        );

        // grab only methods starting with 'test'
        $testMethods = array_filter(
            $publicMethods,
            fn (string $method): bool => strpos($method, 'test') === 0,
        );

        // reset indexes back to 0, 1 etc...
        return array_values($testMethods);
    }
}
