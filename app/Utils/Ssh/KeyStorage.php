<?php

namespace App\Utils\Ssh;

use App\Utils\Ssh\ValueObjects\PrivateKey;

class KeyStorage
{
    /**
     * @param PrivateKey $key
     */
    public function storeKey(PrivateKey $key)
    {
        $path = $key->getPath();

        $this->ensureFileExists($path, $key->getContents());
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
