<?php

declare(strict_types=1);

namespace Inphest\Internal\Result;

final class TestSuiteResult
{
    /**
     * @psalm-var list<TestResultInterface>
     */
    private array $failures = [];

    /**
     * @psalm-var list<TestResultInterface>
     */
    private array $successes = [];

    public function add(TestResultInterface $result): void
    {
        if ($result->isFailure()) {
            $this->failures[] = $result;
        } else {
            $this->successes[] = $result;
        }
    }

    public function count(): int
    {
        return count($this->failures) + count($this->successes);
    }

    public function hasFailures(): bool
    {
        return $this->failures !== [];
    }

    public function failures(): array
    {
        return $this->failures;
    }
}
