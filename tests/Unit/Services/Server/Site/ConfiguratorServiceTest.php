<?php

namespace Tests\Unit\Services\Server\Site;

use App\Events\Server\Site\Deleted;
use App\Events\Task\Running;
use App\Scripts\Server\Site\Create;
use App\Scripts\Server\Site\Delete;
use App\Services\Server\Site\ConfiguratorService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ConfiguratorServiceTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_task_job_should_be_fired_when_site_is_created()
    {
        $this->spyRunningTasks();

        $site = $this->createServerSite();

        $task = $this->getConfiguratorService()->create($site);

        $this->assertTrue($task->owner->is($site));
        $this->assertTrue($task->server->is($site->server));

        $this->assertTaskExecuted($task);

        $this->assertExecutedTaskScript(
            new Create($site)
        );
    }

    function test_a_task_job_should_be_fired_when_site_is_deleted()
    {
        $this->spyRunningTasks();

        $site = $this->createServerSite();

        $task = $this->getConfiguratorService()->delete($site);

        $this->assertTrue($task->owner->is($site));
        $this->assertTrue($task->server->is($site->server));

        $this->assertTaskExecuted($task);

        $this->assertExecutedTaskScript(
            new Delete($site)
        );
    }

    /**
     * @return ConfiguratorService
     */
    protected function getConfiguratorService(): ConfiguratorService
    {
        Event::fake([Create::class, Deleted::class, Running::class]);

        return $this->app[ConfiguratorService::class];
    }
}
