<?php

namespace Tests\Unit\Listeners\Server;

use App\Jobs\Server\RunScript;
use App\Jobs\Task\Run;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Str;
use Tests\TestCase;

class AddPublicKeyToServerTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_task_should_be_created()
    {
        Bus::fake();

        $server = $this->createServer();
        $key = $server->addPublicKey('test', 'test');

        Bus::assertDispatched(RunScript::class, function (RunScript $job) {
            $this->app->call([$job, 'handle']);

            return true;
        });

        Bus::assertDispatched(Run::class, function (Run $job) use ($server) {
            return $job->task->server->is($server) && Str::contains($job->task->name, 'Add SSH Key');
        });
    }
}
