<?php

declare(strict_types=1);

namespace Inphest\Framework\Results;

final class PassingTest implements TestResultInterface
{
    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getOutput(): string
    {
        return '✔ '.$this->name;
    }

    /**
     * @return bool
     */
    public function isFailure(): bool
    {
        return false;
    }
}
