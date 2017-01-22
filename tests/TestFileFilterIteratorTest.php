<?php declare(strict_types = 1);

namespace Inphest\Framework\Tests;

use SplFileInfo;
use ArrayIterator;
use FilterIterator;
use PHPUnit\Framework\TestCase;

use Inphest\Framework\TestFileFilterIterator;

final class TestFileFilterIteratorTest extends TestCase
{
    /**
     * @return void
     */
    public function testItIsAnInstanceOfFilterIteratory() : void
    {
        $testFileFilter = new TestFileFilterIterator(
            new ArrayIterator([])
        );

        $this->assertInstanceOf(FilterIterator::class, $testFileFilter);
    }

    /**
     * @dataProvider validFilenameProvider
     *
     * @param string $validFilename
     * @return void
     */
    public function testItAcceptsTestFilenames(string $validFilename) : void
    {
        $testFileFilter = new TestFileFilterIterator(
            new ArrayIterator([
                new SplFileInfo($validFilename)
            ])
        );

        $this->assertTrue($testFileFilter->accept());
    }

    /**
     * @dataProvider invalidFilenameProvider
     *
     * @param string $invalidFilename
     * @return void
     */
    public function testItRejectsFilenamesThatAreNotTests(string $invalidFilename) : void
    {
        $testFileFilter = new TestFileFilterIterator(
            new ArrayIterator([
                new SplFileInfo($invalidFilename)
            ])
        );

        $this->assertFalse($testFileFilter->accept());
    }

    /**
     * @return void
     */
    public function testItRejectsThingsThatAreNotFiles() : void
    {
        $testFileFilter = new TestFileFilterIterator(
            new ArrayIterator([
                'hello',
                1,
                false,
                []
            ])
        );

        // check none of the values are accepted
        foreach ($testFileFilter as $key => $value) {
            $this->fail('Accepted a value that should not have been: ' . json_encode($value));
        }

        // assert null is invalid (null as no more iterations and we have not rewound)
        $this->assertFalse($testFileFilter->accept());
    }

    /**
     * @return array
     */
    public function validFilenameProvider() : array
    {
        return [
            ['aTest.php'],
            ['SomeTest.php'],
            ['AReallyReallyReallyReallyReallyReallyReallyLongTest.php'],
        ];
    }

    /**
     * @return array
     */
    public function invalidFilenameProvider() : array
    {
        return [
            ['.gitignore'],
            ['README.md'],
            ['TestButNotReally.php'],
            ['some-javascript-file.js'],
            ['hello'],
            ['lowercase-test.php'],
            ['Test.php.txt'],
            ['xTest.phpx'],
        ];
    }
}
