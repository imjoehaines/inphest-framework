<?php declare(strict_types=1);

namespace Inphest\Framework\Hooks;

interface HasHooksInterface
{
    /**
     * Get the hooks this test file has
     *
     * @return iterable
     */
    public function getHooks() : iterable;
}
