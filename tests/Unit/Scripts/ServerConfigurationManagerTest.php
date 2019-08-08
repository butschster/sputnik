<?php

namespace Tests\Unit\Scripts;

use App\Scripts\Contracts\ServerConfiguration;
use App\Scripts\ServerConfigurationManager;
use App\Scripts\Tools\DatabaseConfigurator;
use App\Scripts\Tools\PHPConfigurator;
use App\Scripts\Tools\WebServerConfigurator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ServerConfigurationManagerTest extends TestCase
{
    use DatabaseMigrations;

    function test_gets_php_configuration()
    {
        config()->set('configurations.php', ['56']);

        $server = $this->makeServer([
            'php_version' => '56'
        ]);

        $manager = $this->getServerConfigurationManager($server);

        $this->assertInstanceOf(PHPConfigurator::class, $manager->php());
    }

    function test_gets_database_configuration()
    {
        config()->set('configurations.database', ['mysql']);

        $server = $this->makeServer([
            'database_type' => 'mysql'
        ]);

        $manager = $this->getServerConfigurationManager($server);

        $this->assertInstanceOf(DatabaseConfigurator::class, $manager->database());
    }

    function test_gets_webserver_configuration()
    {
        config()->set('configurations.webserver', ['nginx']);

        $server = $this->makeServer([
            'webserver_type' => 'nginx'
        ]);

        $manager = $this->getServerConfigurationManager($server);

        $this->assertInstanceOf(WebServerConfigurator::class, $manager->webserver());
    }

    function test_gets_system_users()
    {
        config()->set('configurations.system_users', $users = ['test']);
        $server = $this->makeServer();

        $manager = $this->getServerConfigurationManager($server);

        $this->assertEquals($users, $manager->systemUsers());
    }

    function test_it_has_helper_function()
    {
        $server = $this->makeServer();

        $this->assertInstanceOf(ServerConfigurationManager::class, server_configurator($server));
    }

    /**
     * @param ServerConfiguration $configuration
     * @return ServerConfigurationManager
     */
    protected function getServerConfigurationManager(ServerConfiguration $configuration): ServerConfigurationManager
    {
        return new ServerConfigurationManager($configuration);
    }
}
