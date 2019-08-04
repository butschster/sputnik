<?php

namespace Tests\Unit\Models;

use App\Events\Server\Key\AttachedToServer;
use App\Events\Server\Key\DetachedFromServer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class KeyTest extends TestCase
{
    use DatabaseMigrations;

    function test_gets_fingerprint()
    {
        $key = $this->createServerKey([
            'content' => $this->getPublicKey()
        ]);

        $this->assertEquals('b7:97:56:7d:10:11:8e:83:db:ab:2c:1f:33:98:30:3d', $key->fingerprint());
    }

    function test_event_should_be_run_when_key_created()
    {
        Event::fake([
            AttachedToServer::class,
        ]);

        $server = $this->createServer();

        $key = $this->makeServerKey();
        $server->addPublicKey(
            $key->toPublicKey()
        );

        Event::assertDispatched(AttachedToServer::class, function ($event) use ($server, $key) {
            return $event->server->is($server);
        });
    }

    function test_event_should_be_run_when_key_deleted()
    {
        Event::fake([
            DetachedFromServer::class,
        ]);

        $server = $this->createServer();

        $key = $this->makeServerKey();
        $server->addPublicKey(
            $key->toPublicKey()
        );

        $server->removePublicKey($key);


        Event::assertDispatched(DetachedFromServer::class, function ($event) use ($key) {
            return $event->key == $key;
        });
    }
}
