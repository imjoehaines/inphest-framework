<?php

declare(strict_types=1);

namespace Inphest\MetaTests;

use Exception;
use Inphest\Assert;
use function Inphest\test;
use TypeError;

$sameData = [
    '1 === 1' => [1, 1],
    'abc === abc' => ['abc', 'abc'],
    '[] === []' => [[], []],
    'true === true' => [true, true],
    'false === false' => [false, false],
    '$this === $this' => [$this, $this],
];

test('`same` works correctly', static function (Assert $assert, $expected, $actual): void {
    $assert->same($expected, $actual);
})->with($sameData);

test('invoke works correctly', static function (Assert $assert, $expected, $actual): void {
    $assert($expected === $actual);
})->with($sameData);

test('throws (with exception)', static function (Assert $assert): void {
    $assert->throws(static function (): void {
        throw new Exception('oh no');
    }, new Exception('oh no'));
});

test('throws (with error)', static function (Assert $assert): void {
    $assert->throws(static function (): void {
        throw new TypeError('bad');
    }, new TypeError('bad'));
});
