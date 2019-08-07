<?php

namespace Tests\Unit\Rules\Server;

use App\Validation\Rules\Server\PublicKey;
use Tests\TestCase;

class PublicKeyTest extends TestCase
{
    function test_an_invalid_public_key_should_not_pass_validation()
    {
        $this->assertFalse(
            $this->getPublicKeyRule()->passes('', 'abc')
        );
    }

    function test_a_valid_public_key_should_not_pass_validation()
    {
        $this->assertTrue(
            $this->getPublicKeyRule()->passes('', $this->getPublicKey())
        );
    }

    function test_validation_message()
    {
        $this->markTestSkipped('Specify validation message for this rule');
    }

    /**
     * @return PublicKey
     */
    protected function getPublicKeyRule()
    {
        return new PublicKey();
    }
}
