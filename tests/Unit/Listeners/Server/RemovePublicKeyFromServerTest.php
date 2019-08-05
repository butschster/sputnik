<?php

namespace Tests\Unit\Listeners\Server;

use App\Jobs\Server\RunScript;
use App\Jobs\Task\Run;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class RemovePublicKeyFromServerTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_task_should_be_created()
    {
        Bus::fake();

        $key = $this->createServerKey();

        $server = $this->createServer();

        $server->addPublicKey($key);
        $server->removePublicKey($key);

        Bus::assertDispatched(RunScript::class, function (RunScript $job) {
            $this->app->call([$job, 'handle']);

            return true;
        });

        Bus::assertDispatched(Run::class, function (Run $job) use ($server) {
            return $job->task->server->is($server) && $job->task->name == 'Syncing SSH Key';
        });
    }
}
