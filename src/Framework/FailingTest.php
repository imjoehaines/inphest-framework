<?php declare(strict_types=1);

namespace Inphest\Framework;

use Throwable;

final class FailingTest implements TestResultInterface
{
    public function __construct(string $name, Throwable $failure)
    {
        $this->name = $name;
        $this->failure = $failure;
    }

    public function getOutput() : string
    {
        return $this->name . PHP_EOL . $this->failure->getMessage();
    }

    public function isFailure() : bool
    {
        return true;
    }
}
