<?php

declare(strict_types=1);

namespace Inphest;

use Closure;
use Inphest\Internal\TestRegistry;

function test(string $label, Closure $test): PublicTestCase
{
    return TestRegistry::register($label, $test);
}
