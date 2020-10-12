<?php

declare(strict_types=1);

namespace Inphest\Internal\Result;

use Closure;
use Inphest\Internal\Stopwatch;

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

    private function __construct()
    {
    }

    /**
     * @param Stopwatch $stopwatch
     * @param Closure(Closure(TestResultInterface): void): void $runTests
     *
     * @return TestSuiteResult
     */
    public static function create(Stopwatch $stopwatch, Closure $runTests): TestSuiteResult
    {
        $suiteResult = new TestSuiteResult();

        $addResult = static function (TestResultInterface $testResult) use ($suiteResult): void {
            if ($testResult->isFailure()) {
                $suiteResult->failures[] = $testResult;
            } else {
                $suiteResult->successes[] = $testResult;
            }
        };

        $suiteResult->timeTaken = $stopwatch->measure(
            static function () use ($runTests, $addResult): void {
                $runTests($addResult);
            }
        );

        return $suiteResult;
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
