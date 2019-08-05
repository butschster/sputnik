<?php

namespace Tests\Unit\Utils\SSH;

use App\Utils\SSH\Contracts\KeyGenerator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class KeyGeneratorTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_key_pair_can_be_generated_for_server()
    {
        $server = $this->createServer();

        /** @var KeyGenerator $generator */
        $generator = $this->app[KeyGenerator::class];

        $keypair = $generator->generateForServer($server);

        $this->assertNotNull($keypair->getPublicKey());
        $this->assertNotNull($keypair->getPrivateKey());
        $this->assertNotNull($keypair->getPassword());
    }
}
