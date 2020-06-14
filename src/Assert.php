<?php

declare(strict_types=1);

namespace Inphest;

use Inphest\Internal\AssertionException;
use Throwable;

final class Assert
{
    /**
     * Assert that $actual is the same as (===) $expected
     *
     * @param mixed $expected
     * @param mixed $actual
     *
     * @throws AssertionException when $expected isn't the same as $actual
     */
    public function same($expected, $actual): void
    {
        if ($expected !== $actual) {
            throw new AssertionException(sprintf(
                '%s is not the same as %s',
                // TODO this is not good serialisation! We need to robustly print
                //      any arbitrary values. Ideally we would then be able to diff
                //      them, but that would be separate to this message
                json_encode($expected, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
                json_encode($actual, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            ));
        }
    }

    /**
     * Assert that the given $callback throws a matching instance of $expected
     *
     * @throws AssertionException when $callback doesn't throw or $expected don't match
     */
    public function throws(callable $callback, Throwable $expected): void
    {
        try {
            $callback();
        } catch (Throwable $e) {
            if (!$e instanceof $expected) {
                throw new AssertionException(sprintf(
                    'Throwable "%s" is not an instance of "%s"',
                    get_class($e),
                    get_class($expected)
                ));
            }

            if ($expected->getMessage() !== $e->getMessage()) {
                throw new AssertionException(sprintf(
                    '"%s" does not match expected message "%s"',
                    $e->getMessage(),
                    $expected->getMessage()
                ));
            }

            if ($expected->getCode() !== $e->getCode()) {
                throw new AssertionException(sprintf(
                    '"%d" does not match expected message "%d"',
                    $e->getCode(),
                    $expected->getCode()
                ));
            }

            return;
        }

        throw new AssertionException(sprintf(
            'Given callable did not throw (expecting "%s (%d)" — "%s")',
            get_class($expected),
            $expected->getCode(),
            $expected->getMessage()
        ));
    }
}
