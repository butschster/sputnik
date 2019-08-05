<?php

namespace Tests\Unit\Utils\SSH;

use App\Utils\SSH\FilesystemKeyStorage;
use App\Utils\SSH\ValueObjects\PrivateKey;
use Tests\TestCase;

class KeyStorageTest extends TestCase
{
    function test_a_private_key_can_be_stored()
    {
        $privateKey = new PrivateKey('test', 'key content');
        @unlink($privateKey->getPath());
        $storage = new FilesystemKeyStorage();

        $storage->storeKey($privateKey);

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
}
