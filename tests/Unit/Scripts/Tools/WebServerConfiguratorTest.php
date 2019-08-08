<?php

namespace Tests\Unit\Scripts\Tools;

use App\Exceptions\Scrpits\ConfigurationNotFoundException;
use App\Scripts\Contracts\ServerConfiguration;
use App\Scripts\Tools\WebServerConfigurator;
use App\Utils\SSH\ValueObjects\PublicKey;
use Tests\TestCase;

class WebServerConfiguratorTest extends TestCase
{
    function test_if_webserer_type_not_found_configurator_should_not_be_created()
    {
        $this->expectException(ConfigurationNotFoundException::class);

        $this->getWebServerConfigurator('unknown');
    }

    function test_gets_type()
    {
        $configurator = $this->getWebServerConfigurator('nginx');
        $this->assertEquals('nginx', $configurator->type());

        $configurator = $this->getWebServerConfigurator('apache');
        $this->assertEquals('apache', $configurator->type());
    }

    function test_gets_available_types()
    {
        $configurator = $this->getWebServerConfigurator();

        $this->assertEquals(['nginx', 'caddy', 'apache'], $configurator->availableTypes());
    }

    /**
     * @dataProvider webserverInstallScriptPartsDataProvider
     */
    function test_gets_install_script($type, array $parts)
    {
        $configurator = $this->getWebServerConfigurator($type);

        $script = $configurator->install();

        foreach ($parts['install'] as $part) {
            $this->assertStringContainsString($part, $script);
        }
    }

    /**
     * @dataProvider webserverInstallScriptPartsDataProvider
     */
    function test_gets_uninstall_script($type, array $parts)
    {
        $configurator = $this->getWebServerConfigurator($type);

        $script = $configurator->uninstall();

        $this->assertStringContainsString($parts['uninstall'], $script);
    }

    /**
     * @dataProvider webserverInstallScriptPartsDataProvider
     */
    function test_gets_restart_script($type, array $parts)
    {
        $configurator = $this->getWebServerConfigurator($type);

        $script = $configurator->restart();

        $this->assertStringContainsString($parts['restart'], $script);
    }

    /**
     * @param string $type
     * @return WebServerConfigurator
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     */
    protected function getWebServerConfigurator(string $type = 'nginx'): WebServerConfigurator
    {
        config()->set('configurations.php', ['11']);
        config()->set('configurations.webserver', ['nginx', 'caddy', 'apache']);

        return new WebServerConfigurator(
            new WebServerConfigurationTest($type)
        );
    }

    function test_gets_created_a_new_site_script()
    {
        $this->markTestSkipped('Cover webserver site creating');
    }

    function webserverInstallScriptPartsDataProvider()
    {
        return [
            [
                'nginx',
                [
                    'restart' => 'service nginx reload',
                    'uninstall' => 'apt-get purge --auto-remove -y --force-yes nginx*',
                    'install' => [
                        'apt-get install -y --force-yes nginx',
                        'service php1.1-fpm restart > /dev/null 2>&1'
                    ]
                ]
            ],
        ];
    }
}

class WebServerConfigurationTest implements ServerConfiguration
{
    /**
     * @var string
     */
    protected $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function phpVersion(): string
    {
        return '11';
    }

    public function databaseType(): string{}

    public function databasePassword(): string {}

    public function databaseHosts(): array {}

    public function webServerType(): string
    {
        return $this->type;
    }

    public function noSqlDatabases(): array{}

    public function systemUsers(): array
    {
        return ['test_user'];
    }

    public function publicKey(): PublicKey {}

    public function callbackUrl(string $message): string
    {
        return 'callback-----url';
    }
}
