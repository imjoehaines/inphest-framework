<?php

declare(strict_types=1);

namespace Inphest\Internal;

use Inphest\Assert;
use ReflectionClass;

final class TestCaseRunnerFactory
{
    private Assert $assert;

    public function __construct(Assert $assert)
    {
        $this->assert = $assert;
    }

    /**
     * @psalm-param class-string $fullyQualifiedClassname
     */
    public function create(string $fullyQualifiedClassname): TestCaseRunner
    {
        $class = new ReflectionClass($fullyQualifiedClassname);

        return new TestCaseRunner(
            $class->newInstance(),
            new TestMethodExtractor(),
            $this->assert
        );
    }
}
