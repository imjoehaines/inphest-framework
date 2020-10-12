<?php

declare(strict_types=1);

namespace Inphest;

interface PublicTestCase
{
    /**
     * Register some data to run against this test
     *
     * This should be an array of arrays, where each child array contains the
     * arguments to pass to the test function. For example:
     *
     * > test('example', function ($assert, $expected, $actual) {
     * >     $assert->same($expected, $actual);
     * > })->with([
     * >     ['hello', 'goodbye'],
     * >     [1, 2],
     * > ]);
     *
     * This will call the test function twice; once with $expected = 'hello',
     * $actual = 'goodbye' and once with $expected = 1, $actual = 2
     *
     * @param array<array-key, array<array-key, mixed>> $data
     * @return void
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function with(array $data): void;
}
