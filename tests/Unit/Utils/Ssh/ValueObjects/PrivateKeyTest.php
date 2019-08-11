<?php

namespace Tests\Unit\Utils\Ssh\ValueObjects;

use App\Utils\SSH\ValueObjects\PrivateKey;
use Tests\TestCase;

class PrivateKeyTest extends TestCase
{
    function test_get_name()
    {
        $key = new PrivateKey('id_rsa', 'key content');

        $this->assertEquals('id_rsa', $key->getName());
    }

    function test_get_content()
    {
        $key = new PrivateKey('id_rsa', 'key content');

        $this->assertEquals('key content', $key->getContents());
    }

    function test_get_path()
    {
        $this->app->instance('path.storage', '/path/to/key');

        $key = new PrivateKey('id_rsa', 'key content');

        $this->assertEquals('/path/to/key/app/keys/id_rsa', $key->getPath());
    }
}
