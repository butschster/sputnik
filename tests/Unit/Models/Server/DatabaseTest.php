<?php

namespace Tests\Unit\Models\Server;

use App\Events\Server\Database\Created;
use App\Events\Server\Database\Deleted;
use App\Models\Server;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    use DatabaseMigrations;

    function test_it_has_server()
    {
        $database = $this->createServerDatabase();

        $this->assertInstanceOf(Server::class, $database->server);
    }

    function test_an_event_should_be_fired_when_database_created()
    {
        Event::fake(Created::class);

        $database = $this->createServerDatabase();

        Event::assertDispatched(Created::class, function ($event) use ($database) {
            return $database->is($event->database);
        });
    }

    function test_an_event_should_be_fired_when_database_deleted()
    {
        Event::fake(Deleted::class);

        $database = $this->createServerDatabase();

        $database->delete();

        Event::assertDispatched(Deleted::class, function ($event) use ($database) {
            return $database->is($event->database);
        });
    }
}
