<?php

namespace App\Utils\SSH;

use App\Utils\SSH\Contracts\Key;
use App\Utils\SSH\Contracts\KeyStorage as KeyStorageContract;
use Illuminate\Filesystem\Filesystem;

class FilesystemKeyStorage implements KeyStorageContract
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Store private key in local storage
     *
     * @param Key $key
     *
     * @return string Path to the file
     */
    public function store(Key $key): string
    {
        $this->ensureFileExists(
            $key->getPath(), $key->getContents()
        );

        return $key->getPath();
    }

    /**
     * Remove private key from the key storage
     *
     * @param Key $key
     * @return void
     */
    public function remove(Key $key): void
    {
        $this->filesystem->delete($key->getPath());
    }

    /**
     * Ensure the given file exists.
     *
     * @param string $path
     * @param string $key
     */
    protected function ensureFileExists(string $path, string $key): void
    {
        $this->filesystem->put($path, $key);
        $this->filesystem->chmod($path, 0600);
    }
}
