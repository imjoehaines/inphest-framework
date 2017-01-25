<?php declare(strict_types=1);

namespace Inphest\Framework\Hooks;

interface HasHooksInterface
{
    public function getHooks() : iterable;
}
