<?php declare(strict_types=1);

namespace Inphest\Framework\Results;

use Throwable;

final class FailingTest implements TestResultInterface
{
    /**
     * @param string $name
     * @param Throwable $failure
     */
    public function __construct(string $name, Throwable $failure)
    {
        $this->name = $name;
        $this->failure = $failure;
    }

    /**
     * @return string
     */
    public function getOutput() : string
    {
        return '✘ ' . $this->name;
    }

    /**
     * @return bool
     */
    public function isFailure() : bool
    {
        return true;
    }
}
