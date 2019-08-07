<?php

namespace App\Utils\SSH;

use App\Utils\SSH\Contracts\KeyStorage as KeyStorageContract;
use App\Utils\SSH\ValueObjects\PrivateKey;
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
     * @param PrivateKey $key
     *
     * @return string Path to the file
     */
    public function store(PrivateKey $key): string
    {
        $this->ensureFileExists(
            $key->getPath(), $key->getContents()
        );

        return $key->getPath();
    }

    /**
     * Remove private key from the key storage
     *
     * @param PrivateKey $key
     * @return void
     */
    public function remove(PrivateKey $key): void
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
