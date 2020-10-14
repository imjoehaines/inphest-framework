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

    private int $timeTaken = 0;

    /**
     * @param list<TestResultInterface> $results
     * @param int $timeTaken
     */
    public function __construct(array $results, int $timeTaken)
    {
        foreach ($results as $result) {
            if ($result->isFailure()) {
                $this->failures[] = $result;
            } else {
                $this->successes[] = $result;
            }
        }

        $this->timeTaken = $timeTaken;
    }

    public function getTimeTaken(): int
    {
        return $this->timeTaken;
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
