<?php declare(strict_types=1);

namespace Inphest\Framework;

use SplFileInfo;
use FilterIterator;

final class TestFileFilterIterator extends FilterIterator
{
    /**
     * Check if the current iteration value is a valid test file (ends in Test.php)
     *
     * @return bool
     */
    public function accept() : bool
    {
        $file = $this->getInnerIterator()->current();

        if (!$file instanceof SplFileInfo) {
            return false;
        }

        return $this->isTestFile($file);
    }

    /**
     * Check if the given file is a valid test file (ends in Test.php)
     *
     * @param SplFileInfo $file
     * @return bool
     */
    private function isTestFile(SplFileInfo $file) : bool
    {
        return preg_match('/^.*Test.php$/', $file->getFilename()) === 1;
    }
}
