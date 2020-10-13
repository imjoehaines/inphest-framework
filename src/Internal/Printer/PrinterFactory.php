<?php

declare(strict_types=1);

namespace Inphest\Internal\Printer;

use Inphest\Internal\Console\Io\OutputInterface;
use InvalidArgumentException;

final class PrinterFactory
{
    public static function create(?string $name, OutputInterface $output): PrinterInterface
    {
        switch ($name) {
            case null:
            case 'pretty':
                return new PrettyPrinter($output);

            case 'simple':
                return new SimplePrinter($output);

            default:
                throw new InvalidArgumentException("No printer named '{$name}' found");
        }
    }
}
