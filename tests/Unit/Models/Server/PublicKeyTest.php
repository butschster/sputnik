<?php

namespace Tests\Unit\Models\Server;

use App\Events\Server\PublicKey\AttachedToServer;
use App\Events\Server\PublicKey\DetachedFromServer;
use App\Models\Server;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PublicKeyTest extends TestCase
{
    use DatabaseMigrations;

    function test_gets_fingerprint()
    {
        $key = $this->createSSHKey([
            'content' => $this->getPublicKey()
        ]);

        $this->assertEquals('b7:97:56:7d:10:11:8e:83:db:ab:2c:1f:33:98:30:3d', $key->fingerprint());
    }

    function test_it_has_server()
    {
        $key = $this->createSSHKey([
            'content' => $this->getPublicKey()
        ]);

        $this->assertInstanceOf(Server::class, $key->server);
    }
}
