<?php

namespace Tests\Unit\Services\Server;

use App\Exceptions\Server\ConfigurationException;
use App\Scripts\Utils\GetAptLockStatus;
use App\Scripts\Utils\GetCurrentDirectory;
use App\Services\Server\ConfiguratorService;
use App\Services\Task\Contracts\Task;
use App\Utils\SSH\Shell\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ConfiguratorServiceTest extends TestCase
{
    use DatabaseMigrations;

    function test_configured_server_cannot_be_configured()
    {
        $this->expectException(ConfigurationException::class);

        $server = $this->createServer();
        $server->markAsConfiguring();

        $this->getConfiguratorService()->configure($server);
    }

    function test_server_with_status_pending_can_be_configured()
    {
        $this->spyRunningTasks();

        $server = $this->createServer();

        $task = $this->getConfiguratorService()->configure($server);

        $this->assertTrue($server->isConfiguring());

        $this->assertTaskExecuted($task);
    }

    function test_if_user_is_not_root_server_is_not_ready_to_configure()
    {
        $server = $this->createServer();

        $this->listenExecutorService(function(Task $task) {
            if ($task->script() == new GetCurrentDirectory()) {
                return new Response(0, '');
            }
        });

        $this->assertFalse(
            $this->getConfiguratorService()->isServerReadyForConfigure($server)
        );
    }

    function test_if_user_is_root_but_apt_is_locked_server_is_not_ready_to_configure()
    {
        $server = $this->createServer();

        $this->listenExecutorService(function(Task $task) {
            if ($task->script() == 'pwd') {
                return new Response(0, '/root');
            }

            if ($task->script() == new GetAptLockStatus()) {
                return new Response(0, '/var/lib/apt/lists/lock');
            }
        });

        $this->assertFalse(
            $this->getConfiguratorService()->isServerReadyForConfigure($server)
        );
    }

    function test_if_user_is_root_and_apt_is_not_locked_server_is_ready_to_configure()
    {
        $server = $this->createServer();

        $this->listenExecutorService(function(Task $task) {
            if ($task->script() == 'pwd') {
                return new Response(0, '/root');
            }

            if ($task->script() == new GetAptLockStatus()) {
                return new Response(0, '');
            }
        });

        $this->assertTrue(
            $this->getConfiguratorService()->isServerReadyForConfigure($server)
        );
    }

    /**
     * @return ConfiguratorService
     */
    protected function getConfiguratorService(): ConfiguratorService
    {
        return $this->app[ConfiguratorService::class];
    }
}
