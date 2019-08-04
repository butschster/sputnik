<?php

namespace Tests\Unit\Utils\Ssh;

use App\Utils\Ssh\ScriptsStorage;
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
