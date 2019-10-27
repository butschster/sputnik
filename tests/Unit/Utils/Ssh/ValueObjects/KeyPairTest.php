<?php

namespace Tests\Unit\Utils\Ssh\ValueObjects;

use Domain\SSH\ValueObjects\KeyPair;
use Tests\TestCase;

class KeyPairTest extends TestCase
{
    function test_get_public_key()
    {
        $pair = new KeyPair('public key', 'private key', 'password');

        $this->assertEquals('public key', $pair->getPublicKey());
    }

    function test_get_private_key()
    {
        $pair = new KeyPair('public key', 'private key', 'password');

        $this->assertEquals('private key', $pair->getPrivateKey());
    }

    function test_get_password()
    {
        $pair = new KeyPair('public key', 'private key', 'password');

        $this->assertEquals('password', $pair->getPassword());
    }
}
