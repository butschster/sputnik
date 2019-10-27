<?php

namespace Tests\Unit\Utils\SSH;

use Domain\SSH\FilesystemKeyStorage;
use Domain\SSH\ValueObjects\PrivateKey;
use Illuminate\Filesystem\Filesystem;
use Tests\TestCase;

class KeyStorageTest extends TestCase
{
    function test_the_private_key_can_be_stored()
    {
        $storage = $this->getFilesystemKeyStorage();
        $storage->store(
            $privateKey = $this->getTestPrivateKey()
        );

        $this->assertFileExists(
            $privateKey->getPath()
        );

        $this->assertEquals(600, decoct(fileperms($privateKey->getPath()) & 0777));

        $this->assertEquals(
            $privateKey->getContents(),
            file_get_contents($privateKey->getPath())
        );

        @unlink($privateKey->getPath());
    }

    function test_the_private_key_can_be_removed()
    {
        $storage = $this->getFilesystemKeyStorage();
        $storage->store(
            $privateKey = $this->getTestPrivateKey()
        );

        $storage->remove($privateKey);

        $this->assertFileNotExists(
            $privateKey->getPath()
        );
    }

    /**
     * @return FilesystemKeyStorage
     */
    protected function getFilesystemKeyStorage(): FilesystemKeyStorage
    {
        return new FilesystemKeyStorage(
            new Filesystem()
        );
    }

    /**
     * @return PrivateKey|string
     */
    protected function getTestPrivateKey(): PrivateKey
    {
        $privateKey = new PrivateKey('test', 'key content');

        @unlink($privateKey->getPath());

        return $privateKey;
    }
}
