<?php

namespace Tests\Unit\Models;

use App\Events\Server\Key\AttachedToServer;
use App\Events\Server\Key\DetachedFromServer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class KeyEventsTest extends TestCase
{
    use DatabaseMigrations;

    function test_event_should_be_run_when_key_created()
    {
        Event::fake([
            AttachedToServer::class,
        ]);

        $server = $this->createServer();

        $key = $this->createSSHKey();
        $server->addPublicKey(
            $key
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

        $key = $this->createSSHKey();
        $server->addPublicKey(
            $key
        );

        $server->removePublicKey($key);

        Event::assertDispatched(DetachedFromServer::class, function ($event) use ($key) {
            return $event->key == $key;
        });
    }
}