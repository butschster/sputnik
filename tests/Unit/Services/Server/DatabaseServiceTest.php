<?php

namespace Tests\Unit\Services\Server;

use App\Events\Server\Database\Created;
use App\Events\Server\Database\Deleted;
use App\Events\Task\Running;
use App\Scripts\Server\Database\Create;
use App\Scripts\Server\Database\Drop;
use App\Services\Server\DatabaseService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class DatabaseServiceTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_task_job_should_be_fired_when_database_is_created()
    {
        $this->spyRunningTasks();

        $database = $this->createServerDatabase();

        $task = $this->getDatabaseService()->create($database);

        $this->assertTrue($task->owner->is($database));
        $this->assertTrue($task->server->is($database->server));

        $this->assertTaskExecuted($task);

        $this->assertExecutedTaskScript(
            new Create($database)
        );
    }

    function test_a_task_job_should_be_fired_when_database_is_deleted()
    {
        $this->spyRunningTasks();

        $database = $this->createServerDatabase();

        $task = $this->getDatabaseService()->delete($database);

        $this->assertTrue($task->owner->is($database));
        $this->assertTrue($task->server->is($database->server));

        $this->assertTaskExecuted($task);

        $this->assertExecutedTaskScript(
            new Drop($database)
        );
    }

    /**
     * @return DatabaseService
     */
    protected function getDatabaseService(): DatabaseService
    {
        Event::fake([Created::class, Deleted::class, Running::class]);

        return $this->app[DatabaseService::class];
    }
}
