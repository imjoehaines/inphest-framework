<?php

declare(strict_types=1);

namespace Inphest\MetaTests;

use Exception;
use Inphest\Assert;
use function Inphest\test;
use TypeError;

test('one is one', function (Assert $assert): void {
    $assert->same(1, 1);
    $assert(1 === 1);
});

test('abc is abc', function (Assert $assert): void {
    $assert->same('abc', 'abc');
    $assert('abc' === 'abc');
});

test('empty array is empty array', function (Assert $assert): void {
    $assert->same([], []);
    $assert([] === []);
});

test('true is true', function (Assert $assert): void {
    $assert->same(true, true);
    $assert(true === true);
});

test('false is false', function (Assert $assert): void {
    $assert->same(false, false);
    $assert(false === false);
});

test('this is this', function (Assert $assert): void {
    $assert->same($this, $this);
    $assert($this === $this);
});

test('throws (with exception)', function (Assert $assert): void {
    $assert->throws(function (): void {
        throw new Exception('oh no');
    }, new Exception('oh no'));
});

test('throws (with error)', function (Assert $assert): void {
    $assert->throws(function (): void {
        throw new TypeError('bad');
    }, new TypeError('bad'));
});
