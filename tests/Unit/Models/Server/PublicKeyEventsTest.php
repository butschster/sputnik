<?php

namespace Tests\Unit\Models\Server;

use App\Events\Server\PublicKey\AttachedToServer;
use App\Events\Server\PublicKey\DetachedFromServer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PublicKeyEventsTest extends TestCase
{
    use DatabaseMigrations;

    function test_event_should_be_run_when_key_created()
    {
        Event::fake([
            AttachedToServer::class,
        ]);

        $server = $this->createServer();

        $server->addPublicKey('test', 'public key content');

        Event::assertDispatched(AttachedToServer::class, function ($event) use ($server) {
            return $event->key->server->is($server);
        });
    }

    function test_event_should_be_run_when_key_deleted()
    {
        Event::fake([
            DetachedFromServer::class,
        ]);

        $server = $this->createServer();
        $key = $server->addPublicKey('test', 'public key content');

        $server->removePublicKey($key);

        Event::assertDispatched(DetachedFromServer::class, function ($event) use ($key) {
            return $event->key == $key;
        });
    }
}