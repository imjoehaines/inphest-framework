<?php declare(strict_types=1);

namespace Inphest\Framework\Tests;

use PHPUnit\Framework\TestCase;

use Inphest\Framework\TestMethodExtractor;

final class TestMethodExtractorTest extends TestCase
{
    /**
     * Test that a class with only protected & private methods does not have any
     * methods to run as tests
     *
     * @return void
     */
    public function testItExtractsNothingWhenThereAreNoPublicMethods() : void
    {
        $instance = new class {
            /**
             * @return void
             */
            protected function shouldNotBeExtracted() : void
            {
            }

            /**
             * @return void
             */
            private function alsoShouldNotBeExtracted() : void
            {
            }
        };

        $expected = [];
        $actual = TestMethodExtractor::extract($instance);

        $this->assertSame($expected, $actual);
    }

    /**
     * Test that a class with public methods that don't start with "test" has no
     * methods to run as tests
     *
     * @return void
     */
    public function testItExtractsNothingWhenThereAreNoPublicMethodsStartingWithTest() : void
    {
        $instance = new class {
            /**
             * @return void
             */
            public function shouldNotBeExtracted() : void
            {
            }

            /**
             * @return void
             */
            public function alsoShouldNotBeExtracted() : void
            {
            }
        };

        $expected = [];
        $actual = TestMethodExtractor::extract($instance);

        $this->assertSame($expected, $actual);
    }

    /**
     * Test that a class with a method starting with "test" has only that method
     * to run as a test
     *
     * @return void
     */
    public function testItExtractsPublicMethodsStartingWithTest() : void
    {
        $instance = new class {
            /**
             * @return void
             */
            public function shouldNotBeExtracted() : void
            {
            }

            /**
             * @return void
             */
            private function alsoShouldNotBeExtracted() : void
            {
            }

            /**
             * @return void
             */
            public function testShouldBeExtracted() : void
            {
            }
        };

        $expected = ['testShouldBeExtracted'];
        $actual = TestMethodExtractor::extract($instance);

        $this->assertSame($expected, $actual);
    }
}
