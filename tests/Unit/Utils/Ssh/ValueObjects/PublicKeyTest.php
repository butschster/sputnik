<?php

namespace Tests\Unit\Utils\Ssh\ValueObjects;

use App\Utils\Ssh\ValueObjects\PublicKey;
use Tests\TestCase;

class PublicKeyTest extends TestCase
{
    function test_a_fingerpring_can_be_generated()
    {
        $key = new PublicKey('test', $this->getPublicKey());

        $this->assertEquals('b7:97:56:7d:10:11:8e:83:db:ab:2c:1f:33:98:30:3d', $key->getFingerprint());
    }
}
