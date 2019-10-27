<?php

namespace Tests\Unit\Utils\SSH;

use Domain\SSH\Services\ScriptsStorage;
use Tests\TestCase;

class ScriptsStorageTest extends TestCase
{
    function test_a_script_should_be_stored()
    {
        $storage = new ScriptsStorage();

        $script = 'Hello world';

        $path = $storage->storeScript($script);

        $this->assertFileExists($path);

        $this->assertStringEqualsFile($path, $script);

        @unlink($path);
    }
}
