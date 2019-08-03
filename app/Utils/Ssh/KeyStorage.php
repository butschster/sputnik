<?php

namespace App\Utils\Ssh;

class KeyStorage
{
    /**
     * @param string $name
     * @param string $key
     */
    public function storeKey(string $name, string $key)
    {
        $path = storage_path('app/keys/'.$name);

        $this->ensureKeyDirectoryExists();
        $this->ensureFileExists($path, $key);
    }

    /**
     * Ensure the SSH key directory exists.
     */
    protected function ensureKeyDirectoryExists()
    {
        if (! is_dir(storage_path('app/keys'))) {
            mkdir(storage_path('app/keys'), 0755, true);
        }
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
