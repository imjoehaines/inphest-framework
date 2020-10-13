<?php

declare(strict_types=1);

namespace Inphest;

use Closure;
use Inphest\Internal\TestRegistry;

/**
 * @param string $label
 * @param Closure(Assert, mixed...): void $test
 * @param array<array-key, array<array-key, mixed>> $data
 *
 * @return void
 */
function test(string $label, Closure $test, array $data = []): void
{
    TestRegistry::register($label, $test, $data);
}
