<?php

declare(strict_types=1);

namespace Inphest\Internal\Console\Io;

use InvalidArgumentException;

final class Input implements InputInterface
{
    /**
     * @psalm-var array<array-key, string>
     */
    private array $arguments;

    /**
     * @psalm-param array<array-key, string> $arguments
     */
    private function __construct(array $arguments)
    {
        $this->arguments = $arguments;
    }

    public function getArgument(int $index): ?string
    {
        return $this->arguments[$index] ?? null;
    }

    public function getOption(string $option): ?string
    {
        return $this->arguments[$option] ?? null;
    }

    /**
     * @param array<mixed> $input
     * @return Input
     */
    public static function from(array $input): Input
    {
        /** @var array<array-key, string> $arguments */
        $arguments = [];

        for ($i = 0; $i < count($input); ++$i) {
            /** @var mixed $option */
            $option = $input[$i];
            self::assertIsString($option);

            if (substr($option, 0, 2) !== '--') {
                $arguments[] = $option;

                continue;
            }

            // TODO error? unrecognised argument
            if ($option !== '--format') {
                continue;
            }

            // TODO error? no value for argument that requires a value
            if ($i === count($input) - 1) {
                continue;
            }

            /** @var mixed $value */
            $value = $input[++$i];
            self::assertIsString($value);

            $arguments['format'] = $value;
        }

        return new Input($arguments);
    }

    /**
     * @param mixed $value
     * @return void
     */
    private static function assertIsString($value): void
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException(sprintf(
                'Input must be an array of strings, %s given',
                gettype($value)
            ));
        }
    }
}
