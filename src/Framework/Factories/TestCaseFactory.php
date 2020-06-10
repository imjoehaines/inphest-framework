<?php

declare(strict_types=1);

namespace Inphest\Framework\Factories;

use Inphest\Assertions\Assert;
use Inphest\Framework\TestCase;
use Inphest\Framework\TestCaseInterface;
use Inphest\Framework\TestMethodExtractor;
use ReflectionClass;

final class TestCaseFactory
{
    private Assert $assert;

    public function __construct(Assert $assert)
    {
        $this->assert = $assert;
    }

    /**
     * @psalm-param class-string $fullyQualifiedClassname
     */
    public function create(string $fullyQualifiedClassname): TestCaseInterface
    {
        $class = new ReflectionClass($fullyQualifiedClassname);

        $instance = $class->newInstance();

        return new TestCase($instance, new TestMethodExtractor(), $this->assert);
    }
}
