<?php declare(strict_types=1);

namespace Inphest\Framework;

final class NamespaceExtractor
{
    /**
     * Get the namespace from a given file
     *
     * This is *far* from foolproof, especially since PHP allows multiple namespaces
     * per file. A more robust approach would be to use `token_get_all` and fetch
     * all namespaces from a file that way, but that seems pointless because
     * no one uses mutliple namespaces per file so this is good enough for now
     *
     * @param string $filePath
     * @return string
     */
    public function from(string $filePath) : string
    {
        $handle = fopen($filePath, 'r');

        while (($line = fgets($handle)) !== false) {
            if (strpos($line, 'namespace') === 0) {
                $parts = explode('namespace ', $line);
                $namespace = array_pop($parts);

                return rtrim(trim($namespace), ';');
            }
        }

        fclose($handle);

        return '';
    }
}
