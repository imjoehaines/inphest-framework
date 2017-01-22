<?php declare(strict_types=1);

namespace Inphest\Framework\Factory;

use SplFileInfo;
use ReflectionClass;
use ReflectionMethod;

use Inphest\Framework\TestCase;
use Inphest\Framework\NamespaceExtractor;

final class TestCaseFactory
{
    public function __construct(NamespaceExtractor $namespaceExtractor)
    {
        $this->namespaceExtractor = $namespaceExtractor;
    }

    /**
     * @param SplFileInfo $file the test file
     * @return TestCase
     */
    public function create(SplFileInfo $file) : TestCase
    {
        $path = $file->getPathname();

        $this->include($path);

        $namespace = $this->namespaceExtractor->from($path);
        $file = $file->getBasename('.php');

        $fullyQualifiedClassName = $namespace . '\\' . $file;
        $class = new ReflectionClass($fullyQualifiedClassName);

        $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

        $tests = array_filter($methods, function (ReflectionMethod $method) {
            return strpos($method->name, 'test') === 0;
        });

        return new TestCase(
            $file,
            $class->newInstance(),
            ...$tests
        );
    }

    public function include(string $path) : void
    {
        include $path;
    }
}
