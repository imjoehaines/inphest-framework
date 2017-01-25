<?php declare(strict_types=1);

namespace Inphest\Assertions;

use Throwable;

use Inphest\Assertions\AssertionException;

final class Assert
{
    /**
     * Assert that $actual is the same as (===) $expected
     *
     * @param mixed $expected
     * @param mixed $actual
     * @return void
     * @throws AssertionException when $expected isn't the same as $actual
     */
    public function same($expected, $actual) : void
    {
        if ($expected !== $actual) {
            throw new AssertionException(sprintf(
                '%s is not the same as %s',
                json_encode($expected),
                json_encode($actual)
            ));
        }
    }

    /**
     * Assert that the given $callback throws an instance of $throwable
     *
     * @param callable $callback
     * @param string $throwable
     * @param string $message
     * @return void
     * @throws AssertionException when $callback doesn't throw or $throwable/$message don't match
     */
    public function throws(callable $callback, string $throwable, string $message = '') : void
    {
        try {
            $callback();
        } catch (Throwable $e) {
            if (!$e instanceof $throwable) {
                throw new AssertionException(sprintf(
                    'Throwable "%s" is not an instance of "%s"',
                    get_class($e),
                    $throwable
                ));
            }

            if ($message && $message !== $e->getMessage()) {
                throw new AssertionException(sprintf(
                    '"%s" does not match expected message "%s"',
                    $e->getMessage(),
                    $message
                ));
            }

            return;
        }

        throw new AssertionException(sprintf(
            'Given callable did not throw (expecting "%s")',
            $throwable
        ));
    }
}
