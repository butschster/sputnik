<?php

namespace App\Utils\SSH;

use App\Utils\SSH\Contracts\KeyStorage as KeyStorageContract;
use App\Utils\SSH\ValueObjects\PrivateKey;

class FilesystemKeyStorage implements KeyStorageContract
{
    /**
     * @param PrivateKey $key
     *
     * @return string Path to the file
     */
    public function storeKey(PrivateKey $key): string
    {
        $path = $key->getPath();

        $this->ensureFileExists($path, $key->getContents());

        return $path;
    }

    /**
     * Ensure the given file exists.
     *
     * @param string $path
     * @param string $key
     */
    protected function ensureFileExists(string $path, string $key)
    {
        file_put_contents($path, $key);

        chmod($path, 0600);
    }
}
