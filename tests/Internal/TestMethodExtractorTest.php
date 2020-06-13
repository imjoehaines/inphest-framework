<?php

declare(strict_types=1);

namespace Inphest\Tests\Internal;

use Inphest\Internal\TestMethodExtractor;

use PHPUnit\Framework\TestCase;

final class TestMethodExtractorTest extends TestCase
{
    /**
     * Test that a class with only protected & private methods does not have any
     * methods to run as tests
     *
     * @return void
     */
    public function testItExtractsNothingWhenThereAreNoPublicMethods(): void
    {
        $instance = new class() {
            protected function shouldNotBeExtracted(): void
            {
                $this->alsoShouldNotBeExtracted();
            }

            private function alsoShouldNotBeExtracted(): void
            {
            }
        };

        $expected = [];
        $actual = (new TestMethodExtractor())->extract($instance);

        $this->assertSame($expected, $actual);
    }

    /**
     * Test that a class with public methods that don't start with "test" has no
     * methods to run as tests
     *
     * @return void
     */
    public function testItExtractsNothingWhenThereAreNoPublicMethodsStartingWithTest(): void
    {
        $instance = new class() {
            public function shouldNotBeExtracted(): void
            {
            }

            public function alsoShouldNotBeExtracted(): void
            {
            }
        };

        $expected = [];
        $actual = (new TestMethodExtractor())->extract($instance);

        $this->assertSame($expected, $actual);
    }

    /**
     * Test that a class with a method starting with "test" has only that method
     * to run as a test
     *
     * @return void
     */
    public function testItExtractsPublicMethodsStartingWithTest(): void
    {
        $instance = new class() {
            public function shouldNotBeExtracted(): void
            {
            }

            private function alsoShouldNotBeExtracted(): void
            {
            }

            public function testShouldBeExtracted(): void
            {
            }
        };

        $expected = ['testShouldBeExtracted'];
        $actual = (new TestMethodExtractor())->extract($instance);

        $this->assertSame($expected, $actual);
    }
}
